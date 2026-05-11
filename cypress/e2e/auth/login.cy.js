// cypress/e2e/login.cy.js

describe('Login Feature Testing', () => {
  
  const testEmail = 'admin@kos.com';
  const testPassword = 'admin123';
  
  beforeEach(() => {
    cy.visit('http://localhost:8000/login')
    // Tunggu halaman dan Alpine.js selesai load
    cy.wait(500)
  })

  // TC_LOGIN_001: Login dengan kredensial yang valid
  it('TC_LOGIN_001 - Harus berhasil masuk dengan kredensial yang valid.', () => {
    cy.get('input[name="email"]').type(testEmail)
    cy.get('input[name="password"]').type(testPassword)
    cy.get('button[type="submit"]').click()
    
    cy.url().should('include', '/dashboard')
    cy.contains('Dashboard').should('be.visible')
  })

  // TC_LOGIN_002: Login dengan email kosong (Client-side validation)
  it('TC_LOGIN_002 - Harus menampilkan pesan kesalahan jika email kosong.', () => {
    cy.get('input[name="password"]').type(testPassword)
    cy.get('button[type="submit"]').click()
    
    // Verifikasi tetap di halaman login
    cy.url().should('include', '/login')
    
    // Verifikasi JavaScript error muncul
    cy.get('#jsErrorAlert').should('not.have.class', 'hidden')
    cy.get('#jsErrorList').should('contain', 'Email tidak boleh kosong!')
    
    // Verifikasi input email memiliki styling error
    cy.get('input[name="email"]').should('have.class', 'border-red-500')
  })

  // TC_LOGIN_003: Login dengan password kosong (Client-side validation)
  it('TC_LOGIN_003 - Harus menampilkan pesan kesalahan jika kata sandi kosong.', () => {
    cy.get('input[name="email"]').type(testEmail)
    cy.get('button[type="submit"]').click()
    
    cy.url().should('include', '/login')
    
    // Verifikasi JavaScript error muncul
    cy.get('#jsErrorAlert').should('not.have.class', 'hidden')
    cy.get('#jsErrorList').should('contain', 'Password tidak boleh kosong!')
    
    // Verifikasi input password memiliki styling error
    cy.get('input[name="password"]').should('have.class', 'border-red-500')
  })

  // TC_LOGIN_004: Login dengan email format tidak valid (Client-side validation)
  it('TC_LOGIN_004 - Harus menampilkan pesan kesalahan jika format email tidak valid.', () => {
    cy.get('input[name="email"]').type('bukan-email')
    cy.get('input[name="password"]').type(testPassword)
    cy.get('button[type="submit"]').click()
    
    cy.url().should('include', '/login')
    
    // Verifikasi JavaScript error muncul
    cy.get('#jsErrorAlert').should('not.have.class', 'hidden')
    cy.get('#jsErrorList').should('contain', 'Format email tidak valid')
    
    cy.get('input[name="email"]').should('have.class', 'border-red-500')
  })

  // TC_LOGIN_005: Login dengan kredensial yang salah (Server-side validation)
  it('TC_LOGIN_005 - Harus menampilkan pesan kesalahan jika kredensial yang digunakan salah.', () => {
    cy.get('input[name="email"]').type('wrong@example.com')
    cy.get('input[name="password"]').type('wrongpassword')
    cy.get('button[type="submit"]').click()
    
    cy.url().should('include', '/login')
    
    // Verifikasi Laravel error muncul
    cy.get('.border-red-500.bg-red-50').should('be.visible')
    cy.contains('Terjadi Kesalahan!').should('be.visible')
  })

  // TC_LOGIN_006: Login dengan password yang salah (Server-side validation)
  it('TC_LOGIN_006 - Harus menampilkan pesan kesalahan jika kata sandi salah.', () => {
    cy.get('input[name="email"]').type(testEmail)
    cy.get('input[name="password"]').type('wrongpassword')
    cy.get('button[type="submit"]').click()
    
    cy.url().should('include', '/login')
    
    // Verifikasi Laravel error muncul
    cy.get('.border-red-500.bg-red-50').should('be.visible')
    cy.contains('Terjadi Kesalahan!').should('be.visible')
  })

  // TC_LOGIN_007: Verifikasi tombol "Show/Hide Password" berfungsi
  it('TC_LOGIN_007 - Harus menampilkan atau menyembunyikan visibilitas kata sandi', () => {
    cy.get('input[name="password"]').type(testPassword)
    
    // Verifikasi awalnya password tersembunyi
    cy.get('input[name="password"]').should('have.attr', 'type', 'password')
    
    // Klik tombol show password - gunakan selector yang benar
    cy.get('button[aria-label="Toggle password"]').click()
    
    // Verifikasi password terlihat
    cy.get('input[name="password"]').should('have.attr', 'type', 'text')
    
    // Klik lagi untuk hide
    cy.get('button[aria-label="Toggle password"]').click()
    cy.get('input[name="password"]').should('have.attr', 'type', 'password')
  })

  // TC_LOGIN_008: Verifikasi link "Daftar sekarang" berfungsi
  it('TC_LOGIN_008 - Harus diarahkan ke halaman pendaftaran.', () => {
    cy.contains('Daftar sekarang').click()
    
    // Verifikasi redirect ke halaman register
    cy.url().should('include', '/register')
  })

  // TC_LOGIN_009: Verifikasi error hilang saat user mengetik
  it('TC_LOGIN_009 - Harus menyembunyikan kesalahan saat pengguna mulai mengetik.', () => {
    // Trigger error dulu
    cy.get('button[type="submit"]').click()
    cy.get('#jsErrorAlert').should('not.have.class', 'hidden')
    
    // Mulai ketik di email
    cy.get('input[name="email"]').type('a')
    
    // Verifikasi error hilang
    cy.get('#jsErrorAlert').should('have.class', 'hidden')
    cy.get('input[name="email"]').should('not.have.class', 'border-red-500')
  })

  // TC_LOGIN_010: Verifikasi redirect jika sudah login
  it('TC_LOGIN_010 - Harus diarahkan ke dashboard jika sudah terautentikasi.', () => {
    // Login terlebih dahulu
    cy.get('input[name="email"]').type(testEmail)
    cy.get('input[name="password"]').type(testPassword)
    cy.get('button[type="submit"]').click()
    
    cy.url().should('include', '/dashboard')
    
    // Coba akses halaman login lagi
    cy.visit('http://localhost:8000/login')
    
    // Verifikasi langsung redirect ke dashboard
    cy.url().should('include', '/dashboard')
  })

  // TC_LOGIN_011: Verifikasi kedua field kosong
  it('TC_LOGIN_011 - Harus menampilkan beberapa kesalahan jika kedua kolom kosong.', () => {
    cy.get('button[type="submit"]').click()
    
    cy.url().should('include', '/login')
    
    // Verifikasi ada 2 error
    cy.get('#jsErrorAlert').should('not.have.class', 'hidden')
    cy.get('#jsErrorList').should('contain', 'Email tidak boleh kosong!')
    cy.get('#jsErrorList').should('contain', 'Password tidak boleh kosong!')
    
    // Kedua input harus punya styling error
    cy.get('input[name="email"]').should('have.class', 'border-red-500')
    cy.get('input[name="password"]').should('have.class', 'border-red-500')
  })

})