package com.practice.maps;

import java.util.HashMap;
import java.util.Map;

public class Maps {

    public static void main(String[] args) {
        Map<Integer, String> mapNames = new HashMap<>();

        // Put method (add an element to the map)
        mapNames.put(1, "John");
        mapNames.put(2, "Jane");

        // Get method (get an element of the map)
        System.out.println("First name: " + mapNames.get(1));
        System.out.println("Second name: " + mapNames.get(2));

        // ContainsKey (check if the map contains an element by key)
        boolean result = mapNames.containsKey(2);
        // ContainsValue (check if the map contains an element by value)
        // boolean result2 = mapNames.containsValue("Steve");

        if (result == true) {
            System.out.println("Key is present");
        } else {
            System.out.println("Key is not present");
        }

        // Remove method (remove an element of the map)
        // mapNames.remove(2);

        boolean isValue = mapNames.containsValue("Jane");

        if (isValue == true) {
            System.out.println("Value is present");
        } else {
            System.out.println("Value is not present and has been removed");
        }

        // KeySet (show the keys of the map)
        System.out.println("Keys: " + mapNames.keySet());

        // Values (show the values of the map)
        System.out.println("Values: " + mapNames.values());
    }
}
