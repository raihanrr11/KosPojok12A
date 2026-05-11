// cypress/e2e/register.cy.js
describe('Register Feature Testing', () => {
  
  beforeEach(() => {
    cy.visit('http://localhost:8000/register')
    // Tunggu halaman dan Alpine.js selesai load
    cy.wait(500)
  })

  // TC-REGISTER-01: Verifikasi input field nama lengkap dengan data email, password, dan konfirmasi password yang valid
  it('TC-REGISTER-01 - Harus berhasil mendaftar dengan nama yang valid, alamat email, kata sandi, dan konfirmasi kata sandi.', () => {
    // Test Steps
    // 1. Buka halaman registrasi
    cy.url().should('include', '/register')
    
    // 2. Masukkan "Budi Santoso" ke field nama lengkap
    cy.get('input[name="name"]').type('Budi Santoso')
    
    // 3. Masukkan "budi@gmail.com" ke field email
    cy.get('input[name="email"]').type('budi@gmail.com')
    
    // 4. Masukkan "12345678" ke field password
    cy.get('input[name="password"]').type('12345678')
    
    // 5. Kemudian masukkan "12345678" ke field konfirmasi password sesuai dengan input password yang sama
    cy.get('input[name="password_confirmation"]').type('12345678')
    
    // 6. Klik tombol "Buat Akun"
    cy.get('button[type="submit"]').contains('Buat Akun').click()
    
    // Expected Result: Sistem menerima input dengan baik dan tidak menampilkan pesan error
    // untuk field email ataupun password, kemudian pengguna akan di arahkan langsung ke halaman dashboard
    
    // Verifikasi berhasil redirect ke dashboard (keluar dari halaman register)
    cy.url().should('not.include', '/register')
    cy.url().should('include', '/dashboard')
  })

  // TC-REGISTER-02: Verifikasi input field data email yang tidak valid
  it('TC-REGISTER-02 - Harus menampilkan pesan kesalahan jika format email tidak valid.', () => {
    // Test Steps
    // 1. Buka halaman registrasi
    cy.url().should('include', '/register')
    
    // 2. Masukkan "Budi Santoso" ke field nama lengkap
    cy.get('input[name="name"]').type('Budi Santoso')
    
    // 3. Masukkan "budisantoso" ke field email (format tidak valid)
    cy.get('input[name="email"]').type('budisantoso')
    
    // 4. Masukkan "12345678" ke field password
    cy.get('input[name="password"]').type('12345678')
    
    // 5. Kemudian masukkan "12345678" ke field konfirmasi password sesuai dengan input password yang sama
    cy.get('input[name="password_confirmation"]').type('12345678')
    
    // 6. Klik tombol "Buat Akun"
    cy.get('button[type="submit"]').contains('Buat Akun').click()
    
    // Expected Result: Sistem tidak menerima input dengan baik dan menampilkan pesan error seperti "Terjadi Kesalahan"
    cy.url().should('include', '/register')
    
    // Verifikasi JavaScript error muncul
    cy.get('#jsErrorAlert').should('not.have.class', 'hidden')
    cy.get('#jsErrorList').should('contain', 'Format email tidak valid')
    
    // Verifikasi input email memiliki styling error
    cy.get('input[name="email"]').should('have.class', 'border-red-500')
    
    // Actual Result: Input ditolak. Sistem menampilkan pesan validasi "Format email tidak valid! 
    // Contoh: user@example.com", dan pengguna tetap berada di halaman Register
    cy.contains('Format email tidak valid').should('be.visible')
  })

  // TC-REGISTER-03: Verifikasi input field data password tidak valid
  it('TC-REGISTER-03 - Harus menampilkan pesan kesalahan jika panjang kata sandi kurang dari 8 karakter.', () => {
    // Test Steps
    // 1. Buka halaman registrasi
    cy.url().should('include', '/register')
    
    // 2. Masukkan "Budi Santoso" ke field nama lengkap
    cy.get('input[name="name"]').type('Budi Santoso')
    
    // 3. Masukkan "budi@gmail.com" ke field email
    cy.get('input[name="email"]').type('budi@gmail.com')
    
    // 4. Masukkan "123" ke field password (kurang dari 8 karakter)
    cy.get('input[name="password"]').type('123')
    
    // 5. Kemudian masukkan "123" ke field konfirmasi password sesuai dengan input password yang sama
    cy.get('input[name="password_confirmation"]').type('123')
    
    // 6. Klik tombol "Buat Akun"
    cy.get('button[type="submit"]').contains('Buat Akun').click()
    
    // Expected Result: Sistem tidak menerima input dengan baik dan menampilkan pesan error seperti "Terjadi Kesalahan"
    cy.url().should('include', '/register')
    
    // Verifikasi JavaScript error muncul
    cy.get('#jsErrorAlert').should('not.have.class', 'hidden')
    cy.get('#jsErrorList').should('contain', 'Password minimal 8 karakter!')
    
    // Verifikasi input password memiliki styling error
    cy.get('input[name="password"]').should('have.class', 'border-red-500')
    
    // Actual Result: Input ditolak. Sistem menampilkan pesan validasi "Password minimal 8 karakter!", 
    // dan pengguna tetap berada di halaman Register
    cy.contains('Password minimal 8 karakter!').should('be.visible')
  })

  // TC-REGISTER-04: Verifikasi input field data nama lengkap tidak valid
  it('TC-REGISTER-04 - Harus menampilkan pesan kesalahan jika nama kurang dari 3 karakter.', () => {
    // Test Steps
    // 1. Buka halaman registrasi
    cy.url().should('include', '/register')
    
    // 2. Masukkan "BS" ke field nama lengkap (kurang dari 3 karakter)
    cy.get('input[name="name"]').type('BS')
    
    // 3. Masukkan "budi@gmail.com" ke field email
    cy.get('input[name="email"]').type('budi@gmail.com')
    
    // 4. Masukkan "12345678" ke field password
    cy.get('input[name="password"]').type('12345678')
    
    // 5. Kemudian masukkan "12345678" ke field konfirmasi password sesuai dengan input password yang sama
    cy.get('input[name="password_confirmation"]').type('12345678')
    
    // 6. Klik tombol "Buat Akun"
    cy.get('button[type="submit"]').contains('Buat Akun').click()
    
    // Expected Result: Sistem tidak menerima input dengan baik dan menampilkan pesan error seperti "Terjadi Kesalahan"
    cy.url().should('include', '/register')
    
    // Verifikasi JavaScript error muncul
    cy.get('#jsErrorAlert').should('not.have.class', 'hidden')
    cy.get('#jsErrorList').should('contain', 'Nama lengkap minimal 3 karakter!')
    
    // Verifikasi input nama memiliki styling error
    cy.get('input[name="name"]').should('have.class', 'border-red-500')
    
    // Actual Result: Input ditolak. Sistem menampilkan pesan validasi "Nama lengkap minimal 3 karakter!", 
    // dan pengguna tetap berada di halaman Register
    cy.contains('Nama lengkap minimal 3 karakter!').should('be.visible')
  })

  // ========== ADDITIONAL TEST CASES (BONUS) ==========
  
  // TC-REGISTER-05: Verifikasi semua field kosong
  it('TC-REGISTER-05 - Harus menampilkan beberapa kesalahan jika semua kolom kosong.', () => {
    cy.get('button[type="submit"]').contains('Buat Akun').click()
    
    cy.url().should('include', '/register')
    
    // Verifikasi JavaScript error muncul dengan multiple error messages
    cy.get('#jsErrorAlert').should('not.have.class', 'hidden')
    cy.get('#jsErrorList').should('contain', 'Nama lengkap tidak boleh kosong!')
    cy.get('#jsErrorList').should('contain', 'Email tidak boleh kosong!')
    cy.get('#jsErrorList').should('contain', 'Password tidak boleh kosong!')
    cy.get('#jsErrorList').should('contain', 'Konfirmasi password tidak boleh kosong!')
    
    // Semua input harus memiliki styling error
    cy.get('input[name="name"]').should('have.class', 'border-red-500')
    cy.get('input[name="email"]').should('have.class', 'border-red-500')
    cy.get('input[name="password"]').should('have.class', 'border-red-500')
    cy.get('input[name="password_confirmation"]').should('have.class', 'border-red-500')
  })

  // TC-REGISTER-06: Verifikasi password dan konfirmasi password tidak cocok
  it('TC-REGISTER-06 - Harus menampilkan pesan kesalahan jika kata sandi tidak cocok.', () => {
    cy.get('input[name="name"]').type('Budi Santoso')
    cy.get('input[name="email"]').type('budi@gmail.com')
    cy.get('input[name="password"]').type('12345678')
    cy.get('input[name="password_confirmation"]').type('87654321') // Berbeda
    cy.get('button[type="submit"]').contains('Buat Akun').click()
    
    cy.url().should('include', '/register')
    cy.get('#jsErrorAlert').should('not.have.class', 'hidden')
    cy.get('#jsErrorList').should('contain', 'Password dan konfirmasi password tidak cocok!')
    
    // Kedua field password harus memiliki styling error
    cy.get('input[name="password"]').should('have.class', 'border-red-500')
    cy.get('input[name="password_confirmation"]').should('have.class', 'border-red-500')
  })

  // TC-REGISTER-07: Verifikasi tombol toggle password visibility
  it('TC-REGISTER-07 - Harus menampilkan atau menyembunyikan visibilitas kata sandi', () => {
    cy.get('input[name="password"]').type('12345678')
    
    // Verifikasi awalnya password tersembunyi
    cy.get('input[name="password"]').should('have.attr', 'type', 'password')
    
    // Klik tombol show password
    cy.get('button[aria-label="Toggle password"]').click()
    
    // Verifikasi password terlihat
    cy.get('input[name="password"]').should('have.attr', 'type', 'text')
    cy.get('input[name="password"]').should('have.value', '12345678')
    
    // Klik lagi untuk hide
    cy.get('button[aria-label="Toggle password"]').click()
    cy.get('input[name="password"]').should('have.attr', 'type', 'password')
  })

  // TC-REGISTER-08: Verifikasi link "Masuk" ke halaman login
  it('TC-REGISTER-08 - Harus diarahkan ke halaman login saat mengklik tautan “Masuk”.', () => {
    cy.contains('a', 'Masuk').click()
    
    // Verifikasi redirect ke halaman login
    cy.url().should('include', '/login')
    cy.contains('h1', 'Masuk').should('be.visible')
  })

  // TC-REGISTER-09: Verifikasi error hilang saat user mengetik
  it('TC-REGISTER-09 - Should hide error alert when user starts typing', () => {
    // Trigger error dulu dengan submit form kosong
    cy.get('button[type="submit"]').contains('Buat Akun').click()
    cy.get('#jsErrorAlert').should('not.have.class', 'hidden')
    
    // Mulai ketik di field nama
    cy.get('input[name="name"]').type('B')
    
    // Verifikasi error alert hilang
    cy.get('#jsErrorAlert').should('have.class', 'hidden')
    
    // Verifikasi styling error di field nama hilang
    cy.get('input[name="name"]').should('not.have.class', 'border-red-500')
  })

  // TC-REGISTER-10: Verifikasi email yang sudah terdaftar (server-side validation)
  it('TC-REGISTER-10 - Harus menampilkan pesan kesalahan jika alamat email sudah ada.', () => {
    cy.get('input[name="name"]').type('Budi Santoso')
    cy.get('input[name="email"]').type('rei@gmail.com') // Email yang sudah ada di database
    cy.get('input[name="password"]').type('12345678')
    cy.get('input[name="password_confirmation"]').type('12345678')
    cy.get('button[type="submit"]').contains('Buat Akun').click()
    
    // Verifikasi tetap di halaman register
    cy.url().should('include', '/register')
    
    // Verifikasi Laravel server-side error muncul
    cy.get('.border-red-500.bg-red-50').should('be.visible')
    cy.contains('Terjadi Kesalahan!').should('be.visible')
  })

})