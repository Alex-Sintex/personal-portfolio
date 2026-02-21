package com.practice.array_list;

import java.util.ArrayList;

public class ArrayL {
    public static void main(String[] args) {
        // ArrayList<String> list = new ArrayList<String>();
        ArrayList<String> list = new ArrayList<>();

        // Add method (add an element to the array)
        list.add("Apple");
        list.add("Grape");
        list.add("Tangerine");

        // Remove method (remove an element of the array)
        list.remove("Apple");

        // Get method (get an element of the array)
        // String element1 = list.get(1);
        // System.out.println(element1);

        // Size method (get the number of elements of the array)
        // int size = list.size();
        // System.out.println(list);
        // System.out.println(size);

        // Contains method (check if the array contains an element)
        list.add("Apple");
        list.add("Mango");
        // boolean result = list.contains("Apple");

        // Set method (replace an element of the array)
        // System.out.println(list);
        list.set(1, "Cherry");
        // System.out.println(list);

        // Clear method (remove all elements of the array)
        // list.clear();
        // System.out.println(list);

        // isEmpty method (check if the array is empty)
        boolean isEmpty = list.isEmpty();
        System.out.println(isEmpty);
    }
}
