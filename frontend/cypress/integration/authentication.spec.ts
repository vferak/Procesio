describe("My First Test", () => {
  Cypress.on("uncaught:exception", () => {
    return false;
  });

  it("visits the app root url", () => {
    cy.visit("/");
    cy.contains("h1", "Manage your business processes with ease!");
  });

  [
    {
      email: "",
      firstName: "",
      lastName: "",
      password: "",
      passwordAgain: "",
      isValid: false,
    },
    {
      email: "test@test.com",
      firstName: "Test",
      lastName: "Test",
      password: "123456a",
      passwordAgain: "123456a",
      isValid: true,
    },
    {
      email: "test@test.com",
      firstName: "Test",
      lastName: "Test",
      password: "123456a",
      passwordAgain: "123",
      isValid: false,
    },
  ].forEach((params) => {
    it("register new user", () => {
      cy.visit("/");
      cy.contains("label", "Register").click({ force: true });
      if (params.email !== "") {
        cy.get("input[name=email]").type(params.email);
      }
      if (params.firstName !== "") {
        cy.get("input[name=firstName]").type(params.firstName);
      }
      if (params.lastName !== "") {
        cy.get("input[name=lastName]").type(params.lastName);
      }
      if (params.password !== "") {
        cy.get("input[name=password]").type(params.password);
      }
      if (params.passwordAgain !== "") {
        cy.get("input[name=passwordAgain]").type(params.passwordAgain);
      }
      cy.get("input[name=registerSubmit]").click();

      if (params.isValid) {
        cy.contains("span", "Registration successful, please log in.");
      } else {
        cy.contains("span", "Registration failed, please check your data.");
      }
    });
  });

  [
    { email: "", password: "", isValid: false },
    { email: "vojtech@ferak.cz", password: "", isValid: false },
    { email: "", password: "asfdgdsfg", isValid: false },
    { email: "vojtech@ferak.cz", password: "123456a", isValid: true },
    { email: "vojtech@ferak.cz", password: "asfdgdsfg", isValid: false },
    { email: "afzcvxcv", password: "123456a", isValid: false },
    { email: "acxzcasca", password: "asfdgdsfg", isValid: false },
  ].forEach((params) => {
    it("login as a user", () => {
      cy.visit("/");
      cy.contains("label", "Log in").click({ force: true });
      if (params.email !== "") {
        cy.get("input[name=loginEmail]").type(params.email);
      }
      if (params.password !== "") {
        cy.get("input[name=loginPassword]").type(params.password);
      }
      cy.get("input[name=loginSubmit]").click();

      if (params.isValid) {
        cy.contains("h3", "Dashboard");
      } else {
        cy.contains("span", "Invalid credentials!");
      }
    });
  });
});
