package com.practice.variables;

public class Variables {
    public static void main(String[] args) {
        // Variables = Espacio en memoria para almacenar informacion
        // Numeric variables: int, double, float, char, boolean
        /*
         * int myNumericVariable = 2;
         * int myNumericVariable2 = 3;
         * int result = myNumericVariable + myNumericVariable2;
         * long myVariableLong = 1548741547;
         * System.out.println("Result = " + result);
         * System.out.println("My variable long = " + myVariableLong);
         * 
         * // Decimal variables
         * float myVariableFloat = 3.1523561f; // alcance de 7 decimales
         * double myVariableDouble = 4.15; // alcance de 15 decimales
         * System.out.println(myVariableFloat);
         * System.out.println(myVariableDouble);
         */

        // Character variables
        char character = 'A';
        character = 'a';
        System.out.println(character);

        // String variables
        String string = "Hello world";
        string = "Hello world 2";
        System.out.println(string);

        // Boolean variables
        boolean bool = true;

        if(bool) {
            System.out.println("I'm older than 18");
        } else {
            System.out.println("I'm not older than 18");
        }
    }
}
