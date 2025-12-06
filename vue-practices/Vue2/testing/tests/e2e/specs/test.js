// https://docs.cypress.io/api/table-of-contents

describe("Counter Feature", () => {
  it("user can access to page", () => {
    cy.visit("/");
    cy.contains("h1", "Counter App");
  });
  it("user can increment the counter", () => {
    cy.visit("/");
    cy.get("#counter-info").contains("0");
    cy.contains("button", "Increment").click();
    cy.get("#counter-info").contains("1");
  });
});

/*
 * Cypress commands
 * https://docs.cypress.io/api/commands
 */

/*
cy.visit("/"); // Visit an URL
cy.url(); // Get the current URL
cy.contains("label", "Content"); // Find an element by text
cy.should("contain", "hello cypress"); // Check general purpose about the element applied
cy.should("have.css", "color", "#ff0000"); // Check the general purpose about the applied applied element
cy.request("POST", "uri", {}); // Send a request
cy.get(".class"); // Get an element based on class
cy.get("#id"); // Get an element based on id
cy.get('[data-test-id="myId"]'); // Get an element based on data-test-id
cy.click(); // Click an element
cy.type("username"); // Type into an element
*/
