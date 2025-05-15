/*let f = 1;

while (f <= 10) {
    document.write('Vuelta no. ', f);
    document.write('<br>');
    f++; // Also f = f + 1 or f += 1 are valid
}
document.write('Fin del bucle while');*/

let f = 1;
let sum = 0;
let value;

while (f <= 5) {
    value = parseInt(prompt('Introduce un número: '));
    sum = sum + value;
    f++;
}
document.write("La suma de los números es: ", sum, '<br>');