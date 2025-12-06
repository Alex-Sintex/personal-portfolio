describe("Login Test Feature", () => {
  it("user cannot access protected page when not logged in", () => {
    cy.visit("/");
    cy.url().should("eq", "http://localhost:8080/login");
  });
  it("user with wrong credentials cannot access protected page", () => {
    cy.login("demo@demo.com", "987654");
    cy.contains("p", "Wrong email or password");
    cy.visit("/");
    cy.url().should("eq", "http://localhost:8080/login");
  });
  it("user can successfully login", () => {
    cy.login("admin@admin.com", "12345678");
    cy.url().should("eq", "http://localhost:8080/");
  });
});
