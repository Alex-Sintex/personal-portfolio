<template>
    <section>
        <h3>Añadir Profesor</h3>
        <div><label>Nombre:</label><input type="text" v-model="teacher.teacherName"></div>
        <div><label>Apellidos:</label><input type="text" v-model="teacher.surname"></div>
        <div><label>DNI / NIF:</label><input type="text" v-model="teacher.dni"></div>
        <div><label>Materias:</label><input @keydown.enter="handleSubject()" type="text" v-model="subject"><button
                @click="handleSubject()">Agregar</button></div>
        <div>
            <ul>
                <li v-for="(elm, index) in teacher.subjects" :key="index">{{ elm }}</li>
            </ul>
        </div>
        <div class="form-row vertical">
            <label>
                <input type="checkbox" v-model="teacher.doc" />
                Documentación Entregada
            </label>
            <button @click="handleAddTeacher()">Agregar</button>
        </div>
    </section>

    <section>
        <h3>Listado de profesores</h3>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>DNI / NIF</th>
                    <th>Materias</th>
                    <th>Documentación Entregada</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="elm in teachers" :key="elm.dni">
                    <td>{{ elm.teacherName }}</td>
                    <td>{{ elm.surname }}</td>
                    <td>{{ elm.dni }}</td>
                    <td>
                        <ul>
                            <li v-for="(item, index) in elm.subjects" :key="index">{{ item }}</li>
                        </ul>
                    </td>
                    <td>{{ elm.doc ? 'Entregada' : 'No Entregada' }}</td>
                </tr>
            </tbody>
        </table>
    </section>
</template>

<script lang="ts" setup>
import { Ref, ref } from 'vue'

interface ITeacher {
    teacherName: string,
    surname: string,
    dni: string,
    subjects: Array<string>,
    doc: boolean
}

let teacher: Ref<ITeacher> = ref({
    teacherName: '',
    surname: '',
    dni: '',
    subjects: [],
    doc: false
})

let teachers: Ref<Array<ITeacher>> = ref([])

let subject: Ref<string> = ref('')

const handleSubject = () => {
    teacher.value.subjects.push(subject.value)
    subject.value = ""
}

const handleAddTeacher = () => {
    teachers.value.push({
        teacherName: teacher.value.teacherName,
        surname: teacher.value.surname,
        dni: teacher.value.dni,
        subjects: [...teacher.value.subjects],
        doc: teacher.value.doc
    })
    teacher.value.teacherName = ""
    teacher.value.surname = ""
    teacher.value.dni = ""
    teacher.value.subjects = []
    teacher.value.doc = false
}
</script>

<style scoped>
section {
    max-width: 100%;
    padding: 2rem;
    background-color: #f9fafb;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

h3 {
    margin-bottom: 1.5rem;
    color: #333;
}

div {
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}

label {
    width: 150px;
    font-weight: 600;
    color: #444;
}

input[type="text"],
input[type="checkbox"] {
    flex: 1;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    transition: border-color 0.3s ease;
}

input[type="text"]:focus {
    border-color: #4f46e5;
    /* Indigo focus */
    outline: none;
}

input[type="checkbox"] {
    width: auto;
    margin-right: 0.5rem;
}

button {
    margin-left: 1rem;
    padding: 0.5rem 1rem;
    background-color: #4f46e5;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #4338ca;
}

ul {
    margin: 0;
    padding-left: 1.2rem;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

table th,
table td {
    padding: 0.75rem;
    border: 1px solid #e5e7eb;
    text-align: left;
    vertical-align: top;
}

table thead {
    background-color: #f3f4f6;
}

table tbody tr:nth-child(even) {
    background-color: #f9fafb;
}

.form-row.vertical {
    flex-direction: column;
    align-items: flex-start;
}

.form-row.vertical button {
    margin-left: 0;
    margin-top: 0.75rem;
}
</style>