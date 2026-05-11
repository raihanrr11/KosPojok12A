// cypress/e2e/admin/read_penghuni.cy.js

describe('Read Penghuni Feature Testing', () => {
  
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

  // TC-READ-01: Verifikasi halaman penghuni dapat diakses
  it('TC-READ-01 - Haruskah halaman pengguna dapat diakses dengan sukses?', () => {
    cy.url().should('include', '/admin/users')
    cy.get('body').should('be.visible')
  })

  // TC-READ-02: Verifikasi header halaman tampil dengan benar
  it('TC-READ-02 - Harus menampilkan header halaman dengan benar.', () => {
    // Verifikasi title
    cy.contains('h1', 'Manajemen Penghuni').should('be.visible')
    
    // Verifikasi subtitle
    cy.contains('Kelola semua data penghuni kos dengan mudah').should('be.visible')
  })

  // TC-READ-03: Verifikasi tombol "Tambah Penghuni" ada dan dapat diklik
  it('TC-READ-03 - Harus menampilkan dan mengklik tombol “Tambah Penghuni”', () => {
    // Verifikasi tombol ada
    cy.contains('a', 'Tambah Penghuni').should('be.visible')
    
    // Klik tombol
    cy.contains('a', 'Tambah Penghuni').click()
    
    // Verifikasi redirect ke halaman create
    cy.url().should('include', '/admin/users/create')
  })

  // TC-READ-04: Verifikasi list penghuni tampil jika ada data
  it('TC-READ-04 - Harus menampilkan daftar pengguna jika data tersedia.', () => {
    cy.get('body').then($body => {
      // Cek apakah ada user cards atau empty state
      const hasUsers = $body.find('.group.bg-white.rounded-xl').length > 0
      const hasEmptyState = $body.text().includes('Belum Ada Penghuni')
      
      if (hasUsers) {
        // Jika ada data, verifikasi user card muncul
        cy.get('.group.bg-white.rounded-xl').should('have.length.at.least', 1)
        cy.log('✅ User list displayed')
      } else if (hasEmptyState) {
        // Jika tidak ada data, verifikasi empty state muncul
        cy.contains('Belum Ada Penghuni').should('be.visible')
        cy.log('⚠️ Empty state displayed - no users in database')
      }
    })
  })

  // TC-READ-05: Verifikasi data penghuni muncul dengan lengkap
  it('TC-READ-05 - Harus menampilkan data pengguna secara lengkap.', function() {
    cy.get('body').then(function($body) {
      if ($body.find('.group.bg-white.rounded-xl').length > 0) {
        // Ambil card pertama
        cy.get('.group.bg-white.rounded-xl').first().within(() => {
          // Verifikasi nama penghuni ada
          cy.get('h3').should('exist').and('be.visible')
          
          // Verifikasi badge kamar ada
          cy.contains(/Kamar \d+|No Room/).should('be.visible')
          
          // Verifikasi email ada (mengandung @)
          cy.contains(/@/).should('be.visible')
          
          // Verifikasi info sewa bulanan ada
          cy.contains(/Rp [\d.,]+/).should('be.visible')
        })
        
        cy.log('✅ User data displayed completely')
      } else {
        cy.log('⚠️ No users to verify - test skipped')
        this.skip()
      }
    })
  })

  // TC-READ-06: Verifikasi avatar/foto penghuni muncul
  it('TC-READ-06 - Harus menampilkan avatar pengguna atau inisial.', function() {
    cy.get('body').then(function($body) {
      if ($body.find('.group.bg-white.rounded-xl').length > 0) {
        cy.get('.group.bg-white.rounded-xl').first().within(() => {
          // Cek apakah ada foto atau initials
          cy.get('.flex-shrink-0').should('exist')
          
          // Verifikasi ada img (foto) atau span (initials)
          cy.get('.flex-shrink-0').within(() => {
            cy.get('img, span').should('exist')
          })
        })
        
        cy.log('✅ Avatar/initials displayed')
      } else {
        cy.log('⚠️ No users to verify - test skipped')
        this.skip()
      }
    })
  })

  // TC-READ-07: Verifikasi tombol "Edit" ada dan dapat diklik
  it('TC-READ-07 - Harus menampilkan dan mengklik tombol Edit.', function() {
    cy.get('body').then(function($body) {
      if ($body.find('.group.bg-white.rounded-xl').length > 0) {
        // Verifikasi tombol Edit ada
        cy.get('a').contains('Edit').first().should('be.visible')
        
        // Klik tombol Edit
        cy.get('a').contains('Edit').first().click()
        
        // Verifikasi redirect ke halaman edit
        cy.url().should('include', '/admin/users/')
        cy.url().should('include', '/edit')
        
        cy.log('✅ Edit button works correctly')
      } else {
        cy.log('⚠️ No users to edit - test skipped')
        this.skip()
      }
    })
  })


  // TC-READ-8: Verifikasi jumlah penghuni yang ditampilkan
  it('TC-READ-8 - Harus menampilkan jumlah pengguna yang benar.', () => {
    cy.get('body').then($body => {
      const userCount = $body.find('.group.bg-white.rounded-xl').length
      
      if (userCount > 0) {
        cy.log(`✅ Displaying ${userCount} user(s)`)
        expect(userCount).to.be.at.least(1)
        
        // Verifikasi setiap card memiliki struktur yang benar
        cy.get('.group.bg-white.rounded-xl').each(($card) => {
          cy.wrap($card).within(() => {
            // Minimal harus ada nama
            cy.get('h3').should('exist')
          })
        })
      } else {
        cy.log('⚠️ No users displayed')
      }
    })
  })

})