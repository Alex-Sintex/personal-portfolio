package com.practice.selective_sentence;

import java.util.Scanner;

public class SelectivSentence {
    public static void main(String[] args) {
        // Selective sentence
        Scanner scanner = new Scanner(System.in);

        // // Ask first number
        // System.out.println("Enter the first number :");
        // int num1 = scanner.nextInt();

        // // Ask the second number
        // System.out.println("Enter the second number : ");
        // int num2 = scanner.nextInt();

        // int result = (num1 * num2);
        // System.out.println("Result is : " + result);

        // scanner.close();

        // Switch
        // int condition = 1;

        // switch (condition) {
        // case 1:
        // System.out.println("Condition is 1");
        // break;

        // case 2:
        // System.out.println("Condition is 2");
        // break;
        // case 3:
        // System.out.println("Condition is 3");
        // break;
        // case 4:
        // System.out.println("Condition is 4");
        // break;
        // case 5:
        // System.out.println("Condition is 5");
        // break;

        // default:
        // System.out.println("Condition is not valid");
        // break;
        // }

        // Practice
        System.out.println("What note has you got in the exam?");

        int result = scanner.nextInt();

        switch (result) {
            case 1:
                System.out.println("You're suspended");
                break;
            case 2:
                System.out.println("You're suspended");
                break;
            case 3:
                System.out.println("You're suspended");
                break;
            case 4:
                System.out.println("You're suspended");
                break;
            case 5:
                System.out.println("You passed the exam");
                break;
            default:
                System.out.println("Invalid note");
                break;
        }

        scanner.close();
    }
}
