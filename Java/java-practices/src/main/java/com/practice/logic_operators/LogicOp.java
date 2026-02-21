package com.practice.logic_operators;

public class LogicOp {
    public static void main(String[] args) {
        boolean condition1 = false;
        boolean condition2 = false;

        // if else

        // AND (&&):
        // if (condition1 && condition2) {
        // System.out.println("Condition is true");
        // } else {
        // System.out.println("Condition is false");
        // }

        // OR (||):
        // if (condition1 || condition2) {
        // System.out.println("Condition is true");
        // } else {
        // System.out.println("Condition is false");
        // }

        // NOT (!):
        // Invert the value of the operand. If the operand is true, it becomes false,
        // and vice versa.
        // if(!condition1) {
        // System.out.println("Condition is false");
        // } else {
        // System.out.println("Condition is true");
        // }

        // XOR:
        // Return true if exactly one of the operands is true, and false otherwise.
        if (condition1 ^ condition2) {
            System.out.println("Operands are different");
        } else {
            System.out.println("Operands are the same");
        }

    }
}
