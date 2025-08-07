let fname, age;
fname = prompt('Enter your name...');
age = prompt('Enter your age...');
age = parseInt(age); // Convert age to an integer

if (age >= 18) {
    document.write('WELCOME! ', fname);
} else {
    if (age < 18) {
        document.write(fname, ' eres menor de edad');
    } else {
        document.write('No has ingresado datos');
    }
}