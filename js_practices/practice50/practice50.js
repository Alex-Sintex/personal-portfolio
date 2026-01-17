class Animal {
    // Constructor
  constructor(name, weight, age) {
    this.name = name;
    this.weight = weight;
    this.age = age;
  }
  // Methods
  information() {
    return `${this.name} - ${this.weight} - ${this.age} años`;
  }
}

// Subclasses
class Dog extends Animal {
  constructor(name, weight, age, race) {
    super(name, weight, age);
    this.race = race;
  }

  information() {
    return `${this.name} - ${this.weight} - ${this.age} años - ${this.race}`;
  }
}

class Cat extends Animal {
  constructor(name, weight, age, genre) {
    super(name, weight, age);
    this.genre = genre;
  }

  information() {
    return `${this.name} - ${this.weight} - ${this.age} años - ${this.genre}`;
  }
}

class Rabbit extends Animal {
  constructor(name, weight, age, color) {
    super(name, weight, age);
    this.color = color;
  }

  information() {
    return `${this.name} - ${this.weight} - ${this.age} años - ${this.color}`;
  }
}

// Objects
let dog1 = new Dog("Clifford", 12, 3, "Doberman");
let cat1 = new Cat("Misifus", 5, 2, "Male");
let rabbit1 = new Rabbit("Bugs", 3, 1, "White");
let animals = [dog1, cat1, rabbit1];

// Functions
function showAnimals() {
  let list = document.getElementById("listAnimals");

  for (let animal of animals) {
    let item = document.createElement("li");
    item.innerText = animal.information();
    list.appendChild(item);
  }
}
