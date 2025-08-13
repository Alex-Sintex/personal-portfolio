// var vs let vs const
/*
const edad = 10

if (true) {
    const edad = 20
    console.log(edad)
}

console.log(edad)
*/

/*
* Arrays
const arrayNumero = [10, 20 ,30]
arrayNumero.push(40)
console.log(arrayNumero)
*/

// Cuando son objetos o arrays los valores,
// pueden ser modificados dentro de sus propiedades
const persona = {
    nombre: 'Juanito',
    edad: 20
}

persona.edad = 21
persona.pais = 'Mexico'

console.log(persona)