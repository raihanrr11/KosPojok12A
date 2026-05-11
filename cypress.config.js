const { defineConfig } = require("cypress");

module.exports = defineConfig({
  e2e: {
    // Tambahkan baris ini (sesuaikan port jika bukan 8000)
    baseUrl: 'http://127.0.0.1:8000', 
    
    setupNodeEvents(on, config) {
      // implement node event listeners here
    },
  },
});