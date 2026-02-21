package com.practice.array;

import java.util.Scanner;

public class Array {
    public static void main(String[] args) {
        // Type_data[] name_array = new _type_data[size];

        // String[] students = new String[6];

        // // Insert value into array
        // students[0] = "Pedro";
        // students[1] = "Francesco";
        // students[2] = "Alexandra";
        // students[3] = "Miguel";
        // students[4] = "Valentina";
        // students[5] = "Giovanni";

        // for (int i = 0; i < students.length; i++) {
        // System.out.println(students[i]);
        // }

        // String[] students = { "Mario", "Alexandra", "Pedro", "Valentina", "Giovanni",
        // "Francesco" };

        // students[5] = "Totto";

        // System.out.println(students[0]);
        // System.out.println(students[1]);
        // System.out.println(students[2]);
        // System.out.println(students[3]);
        // System.out.println(students[4]);
        // System.out.println(students[5]);

        // Exam notes
        int[] notes;

        try (Scanner scanner = new Scanner(System.in)) {
            System.out.println("How many students are in the class? ");
            int numStudents = scanner.nextInt();

            System.out.println("\nThere are " + numStudents + " students in the class \n");

            notes = new int[numStudents];

            for (int i = 0; i < notes.length; i++) {
                System.out.print("Enter note for student " + (i + 1) + ": ");
                notes[i] = scanner.nextInt();
            }
        }

        // int final_note = (notes[0] + notes[1] + notes[2]) / notes.length;
        // System.out.println("Your final note is: " + final_note);
        for (int j = 0; j < notes.length; j++) {
            System.out.println("\nNote for student " + (j + 1) + " is: " + notes[j]);
        }
    }
}
