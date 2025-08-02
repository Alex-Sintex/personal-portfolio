document.addEventListener("DOMContentLoaded", () => {
    const toast = new Toasty();

    // Formateo de teléfono
    const phoneInput = document.querySelector('input[type="tel"]');
    phoneInput.addEventListener("input", (e) => {
        let numbers = e.target.value.replace(/\D/g, "");
        if (numbers.length > 0) {
            numbers = numbers.substring(0, 10);
            if (numbers.length > 6) {
                e.target.value = `(${numbers.substring(0, 3)}) ${numbers.substring(3, 6)} ${numbers.substring(6)}`;
            } else if (numbers.length > 3) {
                e.target.value = `(${numbers.substring(0, 3)}) ${numbers.substring(3)}`;
            } else {
                e.target.value = `(${numbers}`;
            }
        } else {
            e.target.value = "";
        }
    });

    // Validaciones
    const isValidEmail = (email) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.toLowerCase());
    const isAllowedEmailDomain = (email) => ['gmail.com', 'hotmail.com', 'outlook.com', 'icloud.com'].includes(email.split('@')[1]?.toLowerCase());
    const isStrongPassword = (pass) => /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/.test(pass);
    const isNameValid = (name) => /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(name);
    const isPhoneFormattedCorrectly = (phone) => /^\(\d{3}\) \d{3} \d{4}$/.test(phone);
    const isEmpty = (value) => !value || value.trim() === '';

    // Elementos clave
    const saveBtn = document.getElementById("saveAccountBtn");
    const currentPassInput = document.getElementById("currentPass");
    const selectBtn = document.getElementById("selectImgBtn");
    const fileInput = document.getElementById("profileImgInput");
    const imgPreview = document.getElementById("profilePreview");

    // Tooltip Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(el => new bootstrap.Tooltip(el))

    // Deshabilitar/habilitar botón según contraseña
    currentPassInput.addEventListener("input", () => {
        const hasValue = currentPassInput.value.trim() !== '';
        saveBtn.disabled = !hasValue;

        // Actualizar tooltip dinámicamente
        const tooltipEl = saveBtn.closest('[data-bs-toggle="tooltip"]');
        if (tooltipEl) {
            const tipInstance = bootstrap.Tooltip.getInstance(tooltipEl);
            if (tipInstance) tipInstance.dispose();
            new bootstrap.Tooltip(tooltipEl);
        }
    });

    // Previsualización de imagen
    selectBtn.addEventListener("click", () => fileInput.click());

    fileInput.addEventListener("change", function () {
        const file = this.files[0];
        if (!file) return;

        const allowedTypes = ['image/jpeg', 'image/png'];
        const maxSizeMB = 1;

        if (!allowedTypes.includes(file.type)) {
            toast.error("Solo se permiten imágenes JPG o PNG.");
            this.value = '';
            return;
        }

        if (file.size > maxSizeMB * 1024 * 1024) {
            toast.error("El archivo debe pesar menos de 1MB.");
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => imgPreview.src = e.target.result;
        reader.readAsDataURL(file);
    });

    // Guardar cambios
    saveBtn.addEventListener("click", function (e) {
        e.preventDefault();

        const firstname = document.querySelector('input[name="firstname"]').value.trim();
        const lastname = document.querySelector('input[name="lastname"]').value.trim();
        const email = document.querySelector('input[name="email"]').value.trim();
        const phone = document.querySelector('input[name="phone"]').value.trim();
        const username = document.querySelector('input[name="username"]').value.trim();
        const currentPass = currentPassInput.value;
        const newPass = document.querySelector('input[name="newPass"]').value;
        const confirmPass = document.querySelector('input[name="confirmPass"]').value;

        if (firstname && !isNameValid(firstname)) return toast.error("Nombre inválido, solo letras y espacios.");
        if (lastname && !isNameValid(lastname)) return toast.error("Apellido inválido, solo letras y espacios.");
        if (email && (!isValidEmail(email) || !isAllowedEmailDomain(email))) return toast.error("Correo inválido o no permitido.");
        if (phone && !isPhoneFormattedCorrectly(phone)) return toast.error("El número debe tener formato (xxx) xxx xxxx.");

        if (!isEmpty(newPass)) {
            if (!isStrongPassword(newPass)) return toast.error("Contraseña insegura: mínimo 8 caracteres, mayúscula, minúscula, número y símbolo.");
            if (newPass !== confirmPass) return toast.error("Las contraseñas no coinciden.");
        }

        if (isEmpty(currentPass)) {
            return toast.error("Contraseña requerida para realizar cambios.");
        }

        const formData = new FormData();
        formData.append('firstname', firstname);
        formData.append('lastname', lastname);
        formData.append('email', email);
        formData.append('phone', phone);
        formData.append('username', username);
        formData.append('currentPass', currentPass);
        formData.append('newPass', newPass);

        if (fileInput.files.length > 0) {
            formData.append('profile_img', fileInput.files[0]);
        }

        fetch("account/update", {
            method: "POST",
            body: formData,
        })
            .then(res => res.json())
            .then(res => {
                if (res.status === "success") {
                    toast.success(res.message);

                    // ✅ Limpiar campos de contraseña tras éxito
                    currentPassInput.value = '';
                    document.querySelector('input[name="newPass"]').value = '';
                    document.querySelector('input[name="confirmPass"]').value = '';
                } else {
                    // Si existen errores específicos, unirlos en un solo mensaje
                    if (res.errors) {
                        const allErrors = Object.values(res.errors)
                            .flat()
                            .join('\n');
                        toast.error(allErrors);
                    } else {
                        toast.error(res.message || "Error al actualizar perfil.");
                    }
                }
            })
            .catch(() => toast.error("Error de red o del servidor"));
    });
});