// AND Operator
/*let continent, age;
continent = prompt("Enter your continent...");
age = prompt("Enter your age...");

if (continent == 'America' && age >= 18) {
    document.write("You are an adult from America");
} else {
    document.write("You are not an adult or you are not from America");
}*/

let day, month, year;
day = prompt('Ingrese dia...');
month = prompt('Ingrese mes...');
year = prompt('Ingrese año...');

if (month == 1 || month == 2 || month == 3) {
    document.write('Pertenece al primer trimestre!');
} else {
    document.write('No pertenece al primer trimestre!');
}