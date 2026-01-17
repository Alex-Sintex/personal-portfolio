class Paper {
  constructor(height, width) {
    this.height = height;
    this.width = width;
  }
}

// Anonymous class
let Paper_A = class {
  constructor(height, width) {
    this.height = height;
    this.width = width;
  }
};

let Paper_B = class PaperX {
  constructor(height, width) {
    this.height = height;
    this.width = width;
  }
};

let paperz = new Paper(5, 9);