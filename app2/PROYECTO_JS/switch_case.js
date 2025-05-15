/*let value;
value = parseInt(prompt('Ingrese valor entre 1 y 3'));

switch (value) {
    case 1:
        document.write('Ingresó uno');
        break;
    case 2:
        document.write('Ingresó dos');
        break;
    case 3:
        document.write('Ingresó tres');
        break;

    default:
        document.write('No ingresó un valor entre 1 y 3');
        break;
}*/

let color;
color = prompt('Ingrese un color: Rojo/Verde/Azul');

switch (color) {
    case 'rojo':
        document.write('Ingresó el color rojo');
        break;

    case 'verde':
        document.write('Ingresó el color verde');
        break;

    case 'azul':
        document.write('Ingresó el color azul');
        break;

    default:
        document.write('No ingresó un color válido');
        break;
}