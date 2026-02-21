package com.practice.data_input;

import java.util.Scanner;

public class DataInput {

    public static void main(String[] args) {
        // Scanner
        Scanner scanner = new Scanner(System.in);
        System.out.println("Enter ur age:");
        int age = scanner.nextInt();

        scanner.nextLine();

        System.out.println("Enter ur name:");
        String name = scanner.nextLine();

        System.out.println("Your name is:" + name);
        System.out.println("Your age is : " + age);

        scanner.close();
    }
}
