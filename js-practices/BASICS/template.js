// template string
// Con `` no es necesario poner "+",
// solo se pone la variable directamente dentro de corchetes
const numero = (num1, num2) => {
    return `El numero es: ${num1 + num2}`
}

const resultado = numero(10, 20)
console.log(resultado)

// Con la función flecha se puede reducir el código
const numeroDos = (num1, num2) => (`El numero es: ${num1 + num2}`)

const resultadoDos = numeroDos(20, 30)
console.log(resultadoDos)