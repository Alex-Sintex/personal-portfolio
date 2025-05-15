let numbers = [];
numbers = [15,80,650,50.30,-10];
document.write('Elementos del array: ', numbers);
document.write('<br>');
document.write('Primer elemento: ', numbers[0]); // Shows a specific element in the array
document.write('<br>');
numbers[0] = 14; // Changes the value of the first element
document.write('Primer elemento cambiado: ', numbers);
document.write('<br>-------------------------');

let fruits = ['manzana', 'peras', 'naranjas', 'mangos'];
document.write('<br>');
document.write('Frutas: ', fruits);
document.write('<br>');

// Methods for arrays

// Shows quantity of elements in the array
document.write('Cantidad: ', fruits.length);
document.write('<br>');

// Shows the last element of the array
document.write('Ultimo elemento: ', numbers[numbers.length - 1]);
document.write('<br>');

// Arrays in type string
document.write('En string: ', numbers.toString());
document.write('<br>');

// Join array types
let letters = ['a', 'b', 'c'];
let numbers2 = [1, 2, 3];
document.write('Alfanumerico: ', letters.concat(numbers2));
document.write('<br>');

// Remove last element of the array
numbers.pop();
document.write(numbers);

// Add element to the end of the array
numbers.push(500);
document.write(numbers)
document.write('<br>');

// Remove first element of the array
numbers.shift();
document.write(numbers);
document.write('<br>');

// Insert element to the beginning of the array
numbers.unshift(140);
document.write(numbers);
document.write('<br>');

// Remove element from the array
numbers.splice(2, 3); // Removes 2 elements starting from index 1
document.write(numbers);
document.write('<br>');

// Copy array
let quantities = [100,200,500,600,800];
let copy = quantities.slice(1,4); // Copies elements from index 1 to 4
document.write('Array copia: ', copy);
document.write('<br>');

// Organize array in alphabetic order
let objects = ['carro', 'botella', 'planeta', 'zorro']
document.write(objects.sort()); // Sorts the array
document.write('<br>');

document.write(objects.reverse()); // Reverses the order of the array