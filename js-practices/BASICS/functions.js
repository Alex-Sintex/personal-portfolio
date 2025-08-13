// Funciones
// Basic function
function sumar (num) {
    console.log(num)
}
sumar(10)

// Función de flecha
const sumarDos = (num1, num2) => (num1 + num2)

const resultado = sumarDos(20, 30)
console.log(resultado)

const mensaje = (nombre) => ('Hola soy ' + nombre)

const resultadoDos = mensaje('Kevin')
console.log(resultadoDos)

// num by default will be 0 if no value is set
const sumaTres = (num = 0) => {
    console.log(num + 3)
}

sumaTres(10)