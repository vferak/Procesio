// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
// Cypress.Commands.add('login', (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })

Cypress.Commands.add("login", () => {
  cy.request({
    method: "POST",
    url: "http://localhost:8081/v1/login",
    body: {
      email: "test@test.com",
      password: "123456a",
    },
  }).then((response) => {
    console.log(response);
    window.localStorage.setItem("jwt", response.body.data.token);
    window.localStorage.setItem(
      "workspace",
      "ef8f8ce5-35b1-43e6-918d-159f5fea2036"
    );
  });
});

Cypress.Commands.add("openNavDrawer", () => {
  cy.get("label[for='navigation-drawer']").first().click();
});
