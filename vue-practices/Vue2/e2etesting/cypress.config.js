const { defineConfig } = require("cypress");

module.exports = defineConfig({
  e2e: {
    specPattern: "tests/e2e/specs/**/*.{js,jsx,ts,tsx}",
    supportFile: "tests/e2e/support/index.js",
  },
});