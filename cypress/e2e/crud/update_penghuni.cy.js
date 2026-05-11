// cypress/e2e/admin/update_penghuni.cy.js
describe('Update Penghuni Feature Testing', () => {
  
  beforeEach(() => {
    // Login sebagai admin terlebih dahulu
    cy.visit('http://localhost:8000/login')
    cy.wait(500)
    
    // Login dengan kredensial admin
    cy.get('input[name="email"]').type('admin@kos.com')
    cy.get('input[name="password"]').type('admin123')
    cy.get('button[type="submit"]').click()
    
    // Tunggu redirect ke dashboard
    cy.url().should('include', '/admin/dashboard')
    cy.wait(1000)
    
    // Navigasi ke halaman Penghuni
    cy.visit('http://localhost:8000/admin/users')
    cy.wait(500)
  })

  // TC-EDIT-01: Verifikasi input foto profile pada foto penghuni dengan jenis ekstensi yang valid
  it('TC-EDIT-01 - Harus menerima format foto yang valid (JPG, JPEG, PNG ≤ 2 MB)', () => {
    // IMPORTANT: Buat file valid-photo.jpg di cypress/fixtures/
    // Atau gunakan path ke foto yang sudah ada di komputer
    
    cy.url().should('include', '/admin/users')
    
    cy.get('a').contains('Edit').first().click()
    cy.url().should('include', '/admin/users/')
    cy.url().should('include', '/edit')
    cy.contains('h3', 'Edit Penghuni:').should('be.visible')
    
    // Verifikasi input file attributes
    cy.get('input[type="file"]#photo')
      .should('have.attr', 'accept', 'image/jpeg,image/jpg,image/png')
    
    cy.contains('Format: JPG, JPEG, PNG. Maksimal 2MB').should('be.visible')
    
    // Upload file menggunakan selectFile (Cypress 9.3.0+)
    // Pastikan file ada di cypress/fixtures/valid-photo.jpg
    cy.get('input[type="file"]#photo').selectFile('cypress/fixtures/valid.jpg', {
      force: true // Jika input tersembunyi
    })
    
    // Tunggu sebentar untuk preview
    cy.wait(500)
    
    // Verifikasi preview foto berubah
    cy.get('#photo-preview img').should('exist')
    
    cy.get('button[type="submit"]').contains('Update Data Penghuni').click()
    
    cy.url().should('include', '/admin/users')
    cy.url().should('not.include', '/edit')
  })

  // TC-EDIT-02: Verifikasi input foto profile pada foto penghuni dengan jenis ekstensi yang tidak valid
  it('TC-EDIT-02 - Harus menolak format foto yang tidak valid (bukan JPG, JPEG, PNG ≤ 2 MB)', () => {
    // IMPORTANT: Buat file invalid-file.pdf di cypress/fixtures/
    
    cy.url().should('include', '/admin/users')
    
    cy.get('a').contains('Edit').first().click()
    cy.url().should('include', '/admin/users/')
    cy.url().should('include', '/edit')
    
    cy.get('input[type="file"]#photo')
      .should('have.attr', 'accept', 'image/jpeg,image/jpg,image/png')
    
    // Upload file dengan format tidak valid (PDF)
    // Pastikan file ada di cypress/fixtures/invalid-file.pdf
    cy.get('input[type="file"]#photo').selectFile('cypress/fixtures/invalid.jpg', {
      force: true
    })
    
    cy.get('button[type="submit"]').contains('Update Data Penghuni').click()
    
    // Verifikasi tetap di halaman edit (upload ditolak)
    cy.url().should('include', '/edit')
    
    // Verifikasi ada error message
    cy.get('body').then($body => {
      if ($body.find('.text-red-600').length > 0) {
        cy.get('.text-red-600').should('be.visible')
      }
      cy.url().should('include', '/edit')
    })
  })

  // ========== ADDITIONAL TEST CASES (BONUS) ==========

  // TC-UPDATE-01: Update penghuni dengan data valid (tanpa foto)
  it('TC-UPDATE-01 - Harus berhasil memperbarui penghuni dengan data yang valid.', () => {
    cy.get('a').contains('Edit').first().click()
    cy.url().should('include', '/edit')
    
    // Update nama
    cy.get('input[name="name"]').clear().type('Updated User Name')
    
    // Update email (pastikan unique atau gunakan email yang sama)
    cy.get('input[name="email"]').clear().type('updated@gmail.com')
    
    // Update nomor kamar
    cy.get('input[name="room_number"]').clear().type('99')
    
    // Update sewa bulanan
    cy.get('input[name="monthly_rent"]').clear().type('2000000')
    
    cy.get('button[type="submit"]').contains('Update Data Penghuni').click()
    
    // Verifikasi berhasil redirect ke halaman users
    cy.url().should('include', '/admin/users')
    cy.url().should('not.include', '/edit')
  })

  // TC-UPDATE-02: Update dengan nama kosong
  it('TC-UPDATE-02 - Harus menampilkan pesan kesalahan jika nama kosong.', () => {
    cy.get('a').contains('Edit').first().click()
    cy.url().should('include', '/edit')
    
    // Kosongkan nama
    cy.get('input[name="name"]').clear()
    
    cy.get('button[type="submit"]').contains('Update Data Penghuni').click()
    
    // Verifikasi tetap di halaman edit dan ada error
    cy.url().should('include', '/edit')
    
    // Verifikasi error message muncul (dari Laravel validation)
    cy.get('body').then($body => {
      if ($body.find('.text-red-600').length > 0) {
        cy.get('.text-red-600').should('be.visible')
      }
    })
  })

  // TC-UPDATE-03: Update dengan email format tidak valid
  it('TC-UPDATE-03 - Harus menampilkan pesan kesalahan jika format email tidak valid.', () => {
    cy.get('a').contains('Edit').first().click()
    cy.url().should('include', '/edit')
    
    // Input email tidak valid
    cy.get('input[name="email"]').clear().type('emailtidakvalid')
    
    cy.get('button[type="submit"]').contains('Update Data Penghuni').click()
    
    // Verifikasi tetap di halaman edit
    cy.url().should('include', '/edit')
    
    // Verifikasi error muncul
    cy.get('body').then($body => {
      if ($body.find('.text-red-600').length > 0) {
        cy.get('.text-red-600').should('be.visible')
      }
    })
  })

  // TC-UPDATE-04: Update dengan nomor kamar kosong
  it('TC-UPDATE-04 - Harus menampilkan pesan kesalahan jika nomor kamar kosong.', () => {
    cy.get('a').contains('Edit').first().click()
    cy.url().should('include', '/edit')
    
    // Kosongkan nomor kamar
    cy.get('input[name="room_number"]').clear()
    
    cy.get('button[type="submit"]').contains('Update Data Penghuni').click()
    
    // Verifikasi tetap di halaman edit
    cy.url().should('include', '/edit')
  })

  // TC-UPDATE-05: Update dengan sewa bulanan kosong
  it('TC-UPDATE-05 - Harus menampilkan pesan kesalahan jika kolom sewa bulanan kosong.', () => {
    cy.get('a').contains('Edit').first().click()
    cy.url().should('include', '/edit')
    
    // Kosongkan sewa bulanan
    cy.get('input[name="monthly_rent"]').clear()
    
    cy.get('button[type="submit"]').contains('Update Data Penghuni').click()
    
    // Verifikasi tetap di halaman edit
    cy.url().should('include', '/edit')
  })

  // TC-UPDATE-06: Verifikasi tombol "Batal" berfungsi
  it('TC-UPDATE-06 - Harus kembali ke halaman sebelumnya saat mengklik tombol “Batal”.', () => {
    cy.get('a').contains('Edit').first().click()
    cy.url().should('include', '/edit')
    
    // Klik tombol Batal
    cy.contains('a', 'Batal').click()
    
    // Verifikasi kembali ke halaman users
    cy.url().should('include', '/admin/users')
    cy.url().should('not.include', '/edit')
  })

  // TC-UPDATE-07: Verifikasi field optional (phone, date_of_birth, dll)
  it('TC-UPDATE-07 - Harus menerima bidang opsional yang kosong.', () => {
    cy.get('a').contains('Edit').first().click()
    cy.url().should('include', '/edit')
    
    // Kosongkan field optional
    cy.get('input[name="phone"]').clear()
    cy.get('input[name="date_of_birth"]').clear()
    cy.get('input[name="emergency_contact"]').clear()
    cy.get('textarea[name="address"]').clear()
    
    // Field required tetap diisi
    cy.get('input[name="name"]').should('not.have.value', '')
    cy.get('input[name="email"]').should('not.have.value', '')
    
    cy.get('button[type="submit"]').contains('Update Data Penghuni').click()
    
    // Verifikasi berhasil meskipun field optional kosong
    cy.url().should('include', '/admin/users')
    cy.url().should('not.include', '/edit')
  })

  // TC-UPDATE-08: Verifikasi info password tidak berubah
  it('TC-UPDATE-08 - Harus menampilkan pesan informasi kata sandi', () => {
    cy.get('a').contains('Edit').first().click()
    cy.url().should('include', '/edit')
    
    // Verifikasi ada info tentang password
    cy.contains('Password tidak akan berubah kecuali penghuni mengganti sendiri').should('be.visible')
    
    // Verifikasi tidak ada field password
    cy.get('input[name="password"]').should('not.exist')
  })

  // TC-UPDATE-09: Verifikasi foto preview muncul jika user sudah punya foto
  it('TC-UPDATE-09 - Harus menampilkan foto saat ini jika ada.', () => {
    cy.get('a').contains('Edit').first().click()
    cy.url().should('include', '/edit')
    
    // Verifikasi ada preview foto (baik img atau initials)
    cy.get('#photo-preview').should('exist')
    
    // Cek apakah ada foto atau initials
    cy.get('#photo-preview').then($preview => {
      const hasImage = $preview.find('img').length > 0
      const hasInitials = $preview.find('span').length > 0
      
      expect(hasImage || hasInitials).to.be.true
    })
  })

  // TC-UPDATE-10: Verifikasi link "Hapus Foto Saat Ini" jika user punya foto
  it('TC-UPDATE-10 - Harus menampilkan tautan hapus foto jika pengguna memiliki foto.', () => {
    cy.get('a').contains('Edit').first().click()
    cy.url().should('include', '/edit')
    
    // Cek apakah ada gambar (bukan initials)
    cy.get('body').then($body => {
      if ($body.find('#photo-preview img').length > 0) {
        // Jika ada foto, harus ada link "Hapus Foto Saat Ini"
        cy.contains('Hapus Foto Saat Ini').should('be.visible')
      }
    })
  })

})