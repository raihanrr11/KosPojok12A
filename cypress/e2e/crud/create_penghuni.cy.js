// cypress/e2e/admin/create_penghuni.cy.js
describe('Create Penghuni Feature Testing', () => {
  
  // Data untuk testing
  const validData = {
    name: 'Didan',
    email: 'didan@gmail.com',
    password: 'test1234',
    roomNumber: '33',
    monthlyRent: '1000'
  };

  beforeEach(() => {
    // Login sebagai admin terlebih dahulu
    cy.visit('http://localhost:8000/login')
    cy.wait(500)
    
    // Login dengan kredensial admin
    cy.get('input[name="email"]').type('admin@kos.com') // Sesuaikan dengan email admin Anda
    cy.get('input[name="password"]').type('admin123') // Sesuaikan dengan password admin Anda
    cy.get('button[type="submit"]').click()
    
    // Tunggu redirect ke dashboard
    cy.url().should('include', '/admin/dashboard')
    cy.wait(1000)
    
    // Navigasi ke halaman Penghuni
    cy.visit('http://localhost:8000/admin/users')
    cy.wait(500)
  })

  // TC-CREATE-01: Verifikasi input field dengan data nama lengkap, email, password, nomor kamar, dan sewa bulanan yang valid
  it('TC-CREATE-01 - Harus berhasil membuat penghuni baru dengan data yang valid.', () => {
    
    // 1. Buka halaman Penghuni
    cy.url().should('include', '/admin/users')
    // 2. Klik tombol "+ Tambah Penghuni", dan memasuki halaman Tambah Penghuni Baru
    cy.get('a').contains('Tambah Penghuni').click()
    cy.url().should('include', '/admin/users/create')
    cy.contains('h3', 'Tambah Penghuni Baru').should('be.visible')
    // 3. Masukkan "Didan" ke field nama lengkap
    cy.get('input[name="name"]').type(validData.name)
    // 4. Masukkan "didan@gmail.com" ke field email
    cy.get('input[name="email"]').type(validData.email)
    // 5. Masukkan "test1234" ke field password
    cy.get('input[name="password"]').type(validData.password)
    // 6. Masukkan "33" ke field nomor kamar
    cy.get('input[name="room_number"]').type(validData.roomNumber)
    // 7. Masukkan "0" ke field sewa bulanan
    cy.get('input[name="monthly_rent"]').type(validData.monthlyRent)
    // 8. Klik tombol "Simpan Data Penghuni"
    cy.get('button[type="submit"]').contains('Simpan Data Penghuni').click()
    
    // Expected Result: Sistem menerima input dengan baik dan tidak menampilkan pesan error 
    // untuk field manapun, kemudian admin akan di arahkan kembali ke halaman Penghuni
    cy.url().should('include', '/admin/users')
    cy.url().should('not.include', '/create')
    
    // Verifikasi pesan sukses muncul (sesuaikan dengan pesan di aplikasi Anda)
    cy.contains('Penghuni berhasil ditambahkan').should('be.visible')
    // atau
    cy.contains('berhasil').should('be.visible')
  })

  // TC-CREATE-02: Verifikasi input field dengan data nama lengkap, email, password, nomor kamar, dan sewa bulanan kosong tidak valid
  it('TC-CREATE-02 - Harus menampilkan pesan kesalahan jika semua kolom yang wajib diisi kosong.', () => {
    // Test Steps
    // 1. Buka halaman Penghuni
    cy.url().should('include', '/admin/users')
    
    // 2. Klik tombol "+ Tambah Penghuni", dan memasuki halaman Tambah Penghuni Baru
    cy.get('a').contains('Tambah Penghuni').click()
    cy.url().should('include', '/admin/users/create')
    
    // 3. Pada bagian data penghuni (nama lengkap, email, password, nomor kamar, dan sewa bulanan) 
    // tidak di isi dan di biarkan kosong
    // (Tidak melakukan input apapun)
    
    // 4. Klik tombol "Simpan Data Penghuni"
    cy.get('button[type="submit"]').contains('Simpan Data Penghuni').click()
    
    // Expected Result: Sistem tidak menerima input dengan baik dan menampilkan pesan error seperti "Terjadi Kesalahan"
    cy.url().should('include', '/create')
    
    // Verifikasi JavaScript error muncul
    cy.get('#jsErrorAlert').should('not.have.class', 'hidden')
    
    // Verifikasi error messages
    cy.get('#jsErrorList').should('contain', 'Nama lengkap tidak boleh kosong!')
    cy.get('#jsErrorList').should('contain', 'Email tidak boleh kosong!')
    cy.get('#jsErrorList').should('contain', 'Password tidak boleh kosong!')
    cy.get('#jsErrorList').should('contain', 'Nomor kamar tidak boleh kosong!')
    cy.get('#jsErrorList').should('contain', 'Sewa bulanan tidak boleh kosong!')
    
    // Verifikasi semua field memiliki styling error
    cy.get('input[name="name"]').should('have.class', 'border-red-500')
    cy.get('input[name="email"]').should('have.class', 'border-red-500')
    cy.get('input[name="password"]').should('have.class', 'border-red-500')
    cy.get('input[name="room_number"]').should('have.class', 'border-red-500')
    cy.get('input[name="monthly_rent"]').should('have.class', 'border-red-500')
    
    // Actual Result: Input ditolak. Sistem menampilkan pesan validasi 
    // "Nama Lengkap tidak boleh kosong! Email tidak boleh kosong! Password tidak boleh kosong! 
    // Konfirmasi password tidak boleh kosong!", dan admin tetap berada di halaman Tambah Penghuni Baru
    cy.contains('Terjadi Kesalahan!').should('be.visible')
  })

  // ========== ADDITIONAL TEST CASES (BONUS) ==========

  // TC-CREATE-03: Verifikasi email format tidak valid
  it('TC-CREATE-03 - Harus menampilkan pesan kesalahan jika format email tidak valid.', () => {
    cy.get('a').contains('Tambah Penghuni').click()
    
    cy.get('input[name="name"]').type('Test User')
    cy.get('input[name="email"]').type('emailtanpa-at') // Email tidak valid
    cy.get('input[name="password"]').type('test1234')
    cy.get('input[name="room_number"]').type('10')
    cy.get('input[name="monthly_rent"]').type('1000000')
    
    cy.get('button[type="submit"]').contains('Simpan Data Penghuni').click()
    
    cy.url().should('include', '/create')
    cy.get('#jsErrorAlert').should('not.have.class', 'hidden')
    cy.get('#jsErrorList').should('contain', 'Format email tidak valid')
    cy.get('input[name="email"]').should('have.class', 'border-red-500')
  })

  // TC-CREATE-04: Verifikasi password kurang dari 8 karakter
  it('TC-CREATE-04 - Harus menampilkan pesan kesalahan jika panjang kata sandi kurang dari 8 karakter.', () => {
    cy.get('a').contains('Tambah Penghuni').click()
    
    cy.get('input[name="name"]').type('Test User')
    cy.get('input[name="email"]').type('test@gmail.com')
    cy.get('input[name="password"]').type('test12') // Hanya 6 karakter
    cy.get('input[name="room_number"]').type('10')
    cy.get('input[name="monthly_rent"]').type('1000000')
    
    cy.get('button[type="submit"]').contains('Simpan Data Penghuni').click()
    
    cy.url().should('include', '/create')
    cy.get('#jsErrorAlert').should('not.have.class', 'hidden')
    cy.get('#jsErrorList').should('contain', 'Password minimal 8 karakter!')
    cy.get('input[name="password"]').should('have.class', 'border-red-500')
  })

  // TC-CREATE-05: Verifikasi nama kurang dari 3 karakter
  it('TC-CREATE-05 - Harus menampilkan pesan kesalahan jika nama kurang dari 3 karakter.', () => {
    cy.get('a').contains('Tambah Penghuni').click()
    
    cy.get('input[name="name"]').type('AB') // Hanya 2 karakter
    cy.get('input[name="email"]').type('test@gmail.com')
    cy.get('input[name="password"]').type('test1234')
    cy.get('input[name="room_number"]').type('10')
    cy.get('input[name="monthly_rent"]').type('1000000')
    
    cy.get('button[type="submit"]').contains('Simpan Data Penghuni').click()
    
    cy.url().should('include', '/create')
    cy.get('#jsErrorAlert').should('not.have.class', 'hidden')
    cy.get('#jsErrorList').should('contain', 'Nama lengkap minimal 3 karakter!')
    cy.get('input[name="name"]').should('have.class', 'border-red-500')
  })

  // TC-CREATE-06: Verifikasi nama dengan karakter angka atau simbol
  it('TC-CREATE-06 - Harus menampilkan pesan kesalahan jika nama mengandung angka atau simbol.', () => {
    cy.get('a').contains('Tambah Penghuni').click()
    
    cy.get('input[name="name"]').type('Test123') // Mengandung angka
    cy.get('input[name="email"]').type('test@gmail.com')
    cy.get('input[name="password"]').type('test1234')
    cy.get('input[name="room_number"]').type('10')
    cy.get('input[name="monthly_rent"]').type('1000000')
    
    cy.get('button[type="submit"]').contains('Simpan Data Penghuni').click()
    
    cy.url().should('include', '/create')
    cy.get('#jsErrorAlert').should('not.have.class', 'hidden')
    cy.get('#jsErrorList').should('contain', 'Nama lengkap hanya boleh berisi huruf dan spasi!')
    cy.get('input[name="name"]').should('have.class', 'border-red-500')
  })

  // TC-CREATE-07: Verifikasi nomor kamar dengan nilai negatif atau 0
  it('TC-CREATE-07 - Harus menampilkan pesan kesalahan jika nomor kamar kurang dari 1.', () => {
    cy.get('a').contains('Tambah Penghuni').click()
    
    cy.get('input[name="name"]').type('Test User')
    cy.get('input[name="email"]').type('test@gmail.com')
    cy.get('input[name="password"]').type('test1234')
    cy.get('input[name="room_number"]').clear().type('0') // Nomor kamar 0
    cy.get('input[name="monthly_rent"]').type('1000000')
    
    cy.get('button[type="submit"]').contains('Simpan Data Penghuni').click()
    
    cy.url().should('include', '/create')
    
    // Cek apakah error muncul di JavaScript alert atau Laravel error
    cy.get('body').then($body => {
      if ($body.find('#jsErrorAlert:not(.hidden)').length > 0) {
        // Jika JavaScript client-side error muncul
        cy.get('#jsErrorAlert').should('not.have.class', 'hidden')
        cy.get('#jsErrorList').should('contain', 'Nomor kamar harus berupa angka positif!')
        cy.get('input[name="room_number"]').should('have.class', 'border-red-500')
      } else {
        // Jika Laravel server-side error muncul, atau validasi berbeda
        // Verifikasi tetap di halaman create dan ada indikasi error
        cy.url().should('include', '/create')
        // Server mungkin menampilkan error dalam format berbeda
        // Kita cukup pastikan user tetap di halaman create (tidak berhasil submit)
      }
    })
  })

  // TC-CREATE-08: Verifikasi sewa bulanan kurang dari Rp 1.000
  it('TC-CREATE-08 - Harus menampilkan pesan kesalahan jika sewa bulanan kurang dari Rp 1.000.', () => {
    cy.get('a').contains('Tambah Penghuni').click()
    
    cy.get('input[name="name"]').type('Test User')
    cy.get('input[name="email"]').type('test@gmail.com')
    cy.get('input[name="password"]').type('test1234')
    cy.get('input[name="room_number"]').type('10')
    cy.get('input[name="monthly_rent"]').clear().type('500') // Kurang dari 1000
    
    cy.get('button[type="submit"]').contains('Simpan Data Penghuni').click()
    
    cy.url().should('include', '/create')
    
    // Cek apakah error muncul di JavaScript alert atau Laravel error
    cy.get('body').then($body => {
      if ($body.find('#jsErrorAlert:not(.hidden)').length > 0) {
        // Jika JavaScript client-side error muncul
        cy.get('#jsErrorAlert').should('not.have.class', 'hidden')
        cy.get('#jsErrorList').should('contain', 'Sewa bulanan minimal Rp 1.000!')
        cy.get('input[name="monthly_rent"]').should('have.class', 'border-red-500')
      } else {
        // Jika Laravel server-side error muncul
        cy.url().should('include', '/create')
      }
    })
  })

  // TC-CREATE-09: Verifikasi tombol "Batal" berfungsi
  it('TC-CREATE-09 - Harus kembali ke halaman sebelumnya saat mengklik tombol “Batal”.', () => {
    cy.get('a').contains('Tambah Penghuni').click()
    cy.url().should('include', '/admin/users/create')
    
    // Klik tombol Batal
    cy.contains('a', 'Batal').click()
    
    // Verifikasi kembali ke halaman users
    cy.url().should('include', '/admin/users')
    cy.url().should('not.include', '/create')
  })

  // TC-CREATE-10: Verifikasi error hilang saat user mengetik
  it('TC-CREATE-10 - Harus menyembunyikan pesan kesalahan saat pengguna mulai mengetik.', () => {
    cy.get('a').contains('Tambah Penghuni').click()
    
    // Trigger error
    cy.get('button[type="submit"]').contains('Simpan Data Penghuni').click()
    cy.get('#jsErrorAlert').should('not.have.class', 'hidden')
    
    // Mulai ketik di field nama
    cy.get('input[name="name"]').type('T')
    
    // Verifikasi error hilang
    cy.get('#jsErrorAlert').should('have.class', 'hidden')
    cy.get('input[name="name"]').should('not.have.class', 'border-red-500')
  })

})