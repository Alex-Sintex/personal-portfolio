// assignment, increment and decrement operators
/*
let a = 1;

document.write('Valor de a: ', a, );
document.write('<br>');
a++; // Increase value by +1
document.write('Valor de a: ', a);
document.write('<br>');
a+=5; // Increase variable
document.write('Valor de a: ', a);
document.write('<br>');
a--; // Decrease value by -1
document.write('Valor de a: ', a);
document.write('<br>');
a-=3; // Decrease variable
document.write('Valor de a: ', a);
document.write('<br>');
a*=2; // Multiply value by 2
document.write('Valor de a: ', a);
document.write('<br>');
a/=3; // Divide value by 3
document.write('Valor de a: ', a);
document.write('<br>');
a**=3; // Raise value to the power of 3
document.write('Valor de a: ', a);
*/

// comparison operators
/*
let value1, value2;
value1 = 20;
value2 = 10;

document.write(value1 > value2);
document.write('<br>');
document.write(value1 < value2);
document.write('<br>');
document.write(value1 == value2);
document.write('<br>');
document.write(value1 != value2);
document.write('<br>');
document.write(value1 <= value2);
document.write('<br>');
document.write(value1 >= value2);
*/

var price = Math.round(399.53); // Round to the nearest integer
document.write('Precio redondeado: ', price);
document.write('<br>');

var price = Math.ceil(299.2); // Round up to the nearest integer without caring about the decimal
document.write('Precio redondeado hacia arriba: ', price);
document.write('<br>');

var price = Math.floor(540.9); // Round down to the nearest integer without caring about the decimal
document.write('Precio redondeado hacia abajo: ', price);
document.write('<br>');

var sine = Math.sin(45); // Calculate sine of 45 degrees
document.write('Seno de 45: ', sine);
document.write('<br>');

var expo = Math.exp(2); // Calculate exponential of a number
document.write('Exponencial de 2: ', expo);
document.write('<br>');

var logarithm = Math.log(10); // Calculate natural logarithm of a number
document.write('Logaritmo natural de 10: ', logarithm);
document.write('<br>');

var absolute = Math.abs(-10); // Calculate absolute value of a number
document.write('Valor absoluto de -10: ', absolute);
document.write('<br>');

var maximum = Math.max(10, 50, 600, 1, 8); // Find maximum value among numbers
document.write('Máximo valor de la lista: ', maximum);
document.write('<br>');

var minimum = Math.min(10, 50, 600, 1, 8); // Find minimum value among numbers
document.write('Mínimo valor de la lista: ', minimum);
document.write('<br>');

var random = Math.random()*10; // Generate a random number between 0 and 1
document.write('Número aleatorio: ', random);
document.write('<br>');

var value = Math.sqrt(81); // Calculate square root of a number
document.write('Raíz cuadrada de 81: ', value);
document.write('<br>');

var exponent = Math.pow(4, 2); // Raise a number to a power
document.write('Valor de 4 a la 2: ', exponent);