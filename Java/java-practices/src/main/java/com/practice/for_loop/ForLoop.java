package com.practice.for_loop;

public class ForLoop {
    public static void main(String[] args) {
        // Syntax
        /*
         * for (int index; condition; increment) {}
         */

        // Example
        // for (int i = 1; i <= 10; i++) {
        // System.out.println(i);
        // }

        // Multiple for loops
        for (int i = 1; i <= 10; i++) {
            int res = 2 * i;
            System.out.println("2 x " + i + " = " + res);
        }
        System.out.println("Loop finished");
    }
}
