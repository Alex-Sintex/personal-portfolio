// Objetos
/*
const mascota = {
    nombre: 'Tom',
    edad: 10,
    vivo: true,
    razas: ['peludo', 'negro']
}
// Mostrar valores del objeto en un array
console.log(mascota.razas[0])
// Acceder y mostrar sus propiedades
console.log(mascota.nombre)
console.log(mascota.edad)
console.log(mascota.vivo)

// Agregar nueva propiedad al objeto
mascota.id = 1
console.log(mascota.id)
*/

/*
const mascota = {
    nombre: 'Tom',
    edad: 10,
    vivo: true,
    razas: ['peludo', 'negro']
}

// Guardar una propiedad de un objeto en una constante
const nombreMascota = mascota.nombre

/*
* Destructuring de objetos = una forma rápida y clara de sacar datos de un objeto y guardarlos en variables
*/
// const {edad, nombre} = mascota
// console.log(nombre)

// Objeto padre "web"
const web = {
    nombre: 'facebook',
    links: {
        enlace: 'www.facebook.com'
    },
    redesSociales: {
        youtube: {
            enlace: 'youtube.com/anonymous',
            nombre: 'anonymous yt'
        }
    },
    instagram: {
        enlace: 'instagram.com/anonymous',
        nombre: 'anonymous ins'
    }
}

// Primera forma de acceder a las propiedades de un objeto específico
const enlaceYT = web.redesSociales.youtube.enlace
console.log(enlaceYT)

// Segunda forma de acceder a las propiedades de un objeto usando Destructuring
const {enlace, nombre} = web.redesSociales.youtube
console.log(enlace)
console.log(nombre)