// https://docs.cypress.io/api/introduction/api.html

describe("My First Test", () => {
  it("visits the app root url", () => {
    cy.visit("/");
    cy.contains("h1", "Manage your business processes with ease!");
  });

  it("register new user", () => {
    cy.visit("/");
    cy.contains("label", "Register").click({ force: true });
    cy.get("input[name=email]").type("test@test.com");
    cy.get("input[name=firstName]").type("Tester");
    cy.get("input[name=lastName]").type("Testovič");
    cy.get("input[name=password]").type("123456a");
    cy.get("input[name=passwordAgain]").type("123456a");
    cy.get("input[name=registerSubmit]").click();
  });
});
