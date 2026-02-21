package com.practice.matrix;

import java.util.Scanner;

public class Matrix {
    public static void main(String[] args) {
        // int[][] matrix = new int/* Rows */[3]/* Columns */[3];

        // matrix[0][0] = 5;

        // System.out.println(matrix[0][0]);

        // matrix[0][0] = 10;
        // System.out.println(matrix[0][0]);

        // String[][] names = new String[5][5];
        // names[0][0] = "Pedro";
        // System.out.println(names[0][0]);

        Scanner scanner = new Scanner(System.in);
        int rows = 3;
        int columns = 3;
        int[][] notes = new int[rows][columns];

        for (int i = 0; i < rows; i++) {
            for (int j = 0; j < columns; j++) {
                System.out.println("Enter note in position [" + i + "][" + j + "]");
                notes[i][j] = scanner.nextInt();
            }
        }

        // Show in console
        for (int i = 0; i < rows; i++) {
            for (int j = 0; j < columns; j++) {
                System.out.println("Matrix in row [" + i + "][" + j + "] = " + notes[i][j]);
            }
            System.out.println(" ");
        }
        scanner.close();
    }
}
