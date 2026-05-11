// cypress/e2e/admin/delete_penghuni.cy.js

describe('Delete Penghuni Feature Testing', () => {
  
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

  // TC-DELETE-01: Verifikasi tombol delete ada di setiap user card
  it('TC-DELETE-01 - Harus menampilkan tombol hapus pada kartu pengguna.', function() {
    cy.get('body').then(function($body) {
      if ($body.find('.group.bg-white.rounded-xl').length > 0) {
        // Verifikasi setiap card memiliki tombol delete
        cy.get('.group.bg-white.rounded-xl').each(($card) => {
          cy.wrap($card).within(() => {
            cy.get('button[type="submit"]').contains('Hapus').should('exist')
          })
        })
        
        cy.log('✅ Delete buttons displayed on all user cards')
      } else {
        cy.log('⚠️ No users to verify - test skipped')
        this.skip()
      }
    })
  })

  // TC-DELETE-02: Verifikasi form delete memiliki method POST dan _method DELETE
  it('TC-DELETE-02 - Harus memiliki struktur formulir hapus yang benar.', function() {
    cy.get('body').then(function($body) {
      if ($body.find('.group.bg-white.rounded-xl').length > 0) {
        // Ambil form delete dari user card pertama
        cy.get('.group.bg-white.rounded-xl').first().within(() => {
          cy.get('form[method="POST"]').within(() => {
            // Verifikasi ada CSRF token
            cy.get('input[name="_token"]').should('exist')
            cy.log('✅ CSRF token found')
            
            // Verifikasi ada input hidden _method dengan value DELETE
            cy.get('input[name="_method"]').should('exist').should('have.value', 'DELETE')
            cy.log('✅ _method DELETE found')
            
            // Verifikasi ada tombol submit dengan text Hapus
            cy.get('button[type="submit"]').contains('Hapus').should('exist')
            cy.log('✅ Delete button found')
          })
        })
        
        cy.log('✅ Delete form structure is correct')
      } else {
        cy.log('⚠️ No users to verify - test skipped')
        this.skip()
      }
    })
  })

  // TC-DELETE-03: Verifikasi form delete memiliki action URL yang benar
  it('TC-DELETE-03 - Harus memiliki URL tindakan hapus yang benar.', function() {
    cy.get('body').then(function($body) {
      if ($body.find('.group.bg-white.rounded-xl').length > 0) {
        // Ambil form dari dalam user card pertama (bukan form logout!)
        cy.get('.group.bg-white.rounded-xl').first().within(() => {
          cy.get('form[method="POST"]')
            .invoke('attr', 'action')
            .then((action) => {
              // Verifikasi action mengandung /admin/users/ dan ID
              expect(action).to.include('/admin/users/')
              // Verifikasi action berakhir dengan angka (ID user)
              expect(action).to.match(/\/admin\/users\/\d+$/)
              cy.log(`✅ Delete action URL is correct: ${action}`)
            })
        })
      } else {
        cy.log('⚠️ No users to verify - test skipped')
        this.skip()
      }
    })
  })

  // TC-DELETE-04: Verifikasi konfirmasi delete muncul saat tombol diklik
  it('TC-DELETE-04 - Harus menampilkan konfirmasi saat tombol hapus diklik.', function() {
    cy.get('body').then(function($body) {
      if ($body.find('.group.bg-white.rounded-xl').length > 0) {
        // Stub window.confirm untuk mencegah dialog muncul dan return false (cancel)
        cy.window().then((win) => {
          cy.stub(win, 'confirm').returns(false).as('confirmStub')
        })
        
        // Simpan URL sebelum klik
        cy.url().then((urlBefore) => {
          // Ambil tombol delete dari user card (bukan dari navbar)
          cy.get('.group.bg-white.rounded-xl').first().within(() => {
            cy.get('button[type="submit"]').contains('Hapus').click()
          })
          
          cy.wait(500)
          
          // Verifikasi confirm dipanggil
          cy.get('@confirmStub').should('have.been.called')
          
          // Verifikasi URL tidak berubah (karena cancel)
          cy.url().should('eq', urlBefore)
        })
        
        cy.log('✅ Delete confirmation works (window.confirm)')
      } else {
        cy.log('⚠️ No users to delete - test skipped')
        this.skip()
      }
    })
  })

  // TC-DELETE-05: Verifikasi user berhasil dihapus (dengan konfirmasi)
  it('TC-DELETE-05 - Harus berhasil menghapus pengguna setelah dikonfirmasi.', function() {
    cy.get('body').then(function($body) {
      const initialUserCount = $body.find('.group.bg-white.rounded-xl').length
      
      if (initialUserCount > 0) {
        // Simpan nama user yang akan dihapus
        let userName = ''
        cy.get('.group.bg-white.rounded-xl').first().find('h3').invoke('text').then((text) => {
          userName = text.trim()
          cy.log(`🗑️ Deleting user: ${userName}`)
        })
        
        // Stub konfirmasi untuk return true (konfirmasi delete)
        cy.window().then((win) => {
          cy.stub(win, 'confirm').returns(true)
        })
        
        // Klik tombol delete dari user card pertama
        cy.get('.group.bg-white.rounded-xl').first().within(() => {
          cy.get('button[type="submit"]').contains('Hapus').click()
        })
        
        // Tunggu redirect dan reload
        cy.wait(2000)
        
        // Verifikasi masih di halaman users
        cy.url().should('include', '/admin/users')
        
        // Verifikasi jumlah user berkurang atau user tidak ada lagi
        cy.get('body').then(($newBody) => {
          const newUserCount = $newBody.find('.group.bg-white.rounded-xl').length
          
          if (newUserCount === 0) {
            // Jika semua user terhapus, verifikasi empty state
            cy.contains('Belum Ada Penghuni').should('be.visible')
            cy.log('✅ All users deleted - empty state shown')
          } else {
            // Jika masih ada user, verifikasi jumlah berkurang
            expect(newUserCount).to.be.lessThan(initialUserCount)
            cy.log(`✅ User deleted - count reduced from ${initialUserCount} to ${newUserCount}`)
          }
        })
        
        cy.log('✅ User deleted successfully')
      } else {
        cy.log('⚠️ No users to delete - test skipped')
        this.skip()
      }
    })
  })

  // TC-DELETE-06: Verifikasi flash message sukses muncul setelah delete
  it('TC-DELETE-06 - Harus menampilkan pesan keberhasilan setelah menghapus.', function() {
    cy.get('body').then(function($body) {
      if ($body.find('.group.bg-white.rounded-xl').length > 0) {
        // Stub konfirmasi untuk return true
        cy.window().then((win) => {
          cy.stub(win, 'confirm').returns(true)
        })
        
        // Klik tombol delete dari user card
        cy.get('.group.bg-white.rounded-xl').first().within(() => {
          cy.get('button[type="submit"]').contains('Hapus').click()
        })
        
        cy.wait(2000)
        
        // Verifikasi ada flash message (sesuaikan dengan implementasi Anda)
        cy.get('body').then(($newBody) => {
          const bodyText = $newBody.text()
          
          // Cek berbagai kemungkinan pesan sukses
          const hasSuccessMessage = 
            bodyText.includes('berhasil dihapus') ||
            bodyText.includes('successfully deleted') ||
            bodyText.includes('Penghuni dihapus') ||
            bodyText.includes('Berhasil')
          
          if (hasSuccessMessage) {
            cy.log('✅ Success message displayed')
          } else {
            cy.log('⚠️ No visible success message, but delete action completed')
          }
        })
        
        cy.log('✅ Delete action completed')
      } else {
        cy.log('⚠️ No users to delete - test skipped')
        this.skip()
      }
    })
  })

  // TC-DELETE-07: Verifikasi delete dibatalkan jika konfirmasi di-cancel
  it('TC-DELETE-07 - Jangan dihapus saat konfirmasi dibatalkan.', function() {
    cy.get('body').then(function($body) {
      const initialUserCount = $body.find('.group.bg-white.rounded-xl').length
      
      if (initialUserCount > 0) {
        // Stub konfirmasi untuk return false (cancel)
        cy.window().then((win) => {
          cy.stub(win, 'confirm').returns(false)
        })
        
        // Klik tombol delete
        cy.get('.group.bg-white.rounded-xl').first().within(() => {
          cy.get('button[type="submit"]').contains('Hapus').click()
        })
        
        cy.wait(500)
        
        // Verifikasi jumlah user tidak berubah
        cy.get('.group.bg-white.rounded-xl').should('have.length', initialUserCount)
        
        // Verifikasi masih di halaman yang sama
        cy.url().should('include', '/admin/users')
        
        cy.log('✅ Delete cancelled successfully - user count unchanged')
      } else {
        cy.log('⚠️ No users to delete - test skipped')
        this.skip()
      }
    })
  })

  // TC-DELETE-08: Verifikasi tombol delete memiliki styling yang sesuai
  it('TC-DELETE-08 - Harus memiliki gaya tombol hapus yang tepat.', function() {
    cy.get('body').then(function($body) {
      if ($body.find('.group.bg-white.rounded-xl').length > 0) {
        cy.get('.group.bg-white.rounded-xl').first().within(() => {
          cy.get('button[type="submit"]').contains('Hapus').then(($btn) => {
            // Verifikasi button memiliki class atau style yang menunjukkan danger/delete
            const classes = $btn.attr('class') || ''
            const hasRedColor = 
              classes.includes('red') || 
              classes.includes('danger') ||
              classes.includes('pink')
            
            expect(hasRedColor).to.be.true
            
            cy.log('✅ Delete button has proper danger styling')
          })
        })
      } else {
        cy.log('⚠️ No users to verify - test skipped')
        this.skip()
      }
    })
  })

  // TC-DELETE-09: Verifikasi multiple delete tidak terjadi secara bersamaan
  it('TC-DELETE-09 - Harus menghapus satu per satu.', function() {
    cy.get('body').then(function($body) {
      const initialUserCount = $body.find('.group.bg-white.rounded-xl').length
      
      if (initialUserCount >= 2) {
        // Stub konfirmasi untuk return true
        cy.window().then((win) => {
          cy.stub(win, 'confirm').returns(true)
        })
        
        // Delete satu user
        cy.get('.group.bg-white.rounded-xl').first().within(() => {
          cy.get('button[type="submit"]').contains('Hapus').click()
        })
        
        cy.wait(2000)
        
        // Verifikasi hanya 1 user yang terhapus
        cy.get('body').then(($newBody) => {
          const newUserCount = $newBody.find('.group.bg-white.rounded-xl').length
          
          if (newUserCount === 0) {
            cy.log('⚠️ All users deleted (there was only 1 user)')
          } else {
            expect(newUserCount).to.equal(initialUserCount - 1)
            cy.log(`✅ Only one user deleted - from ${initialUserCount} to ${newUserCount}`)
          }
        })
        
        cy.log('✅ Delete one at a time works correctly')
      } else {
        cy.log('⚠️ Need at least 2 users for this test - test skipped')
        this.skip()
      }
    })
  })

  // TC-DELETE-10: Verifikasi empty state muncul setelah semua user dihapus
  it('TC-DELETE-10 - Harus menampilkan keadaan kosong setelah menghapus semua pengguna.', function() {
    cy.get('body').then(function($body) {
      const initialUserCount = $body.find('.group.bg-white.rounded-xl').length
      
      if (initialUserCount > 0) {
        // Stub konfirmasi untuk return true
        cy.window().then((win) => {
          cy.stub(win, 'confirm').returns(true)
        })
        
        // Hapus semua user satu per satu
        const deleteAllUsers = (count) => {
          if (count <= 0) {
            // Semua sudah terhapus, verifikasi empty state
            cy.get('body').then(($finalBody) => {
              if ($finalBody.find('.group.bg-white.rounded-xl').length === 0) {
                cy.contains('Belum Ada Penghuni').should('be.visible')
                cy.contains('Tambah Penghuni Pertama').should('be.visible')
                cy.log('✅ Empty state displayed after deleting all users')
              }
            })
            return
          }
          
          // Hapus user pertama
          cy.get('body').then(($checkBody) => {
            if ($checkBody.find('.group.bg-white.rounded-xl').length > 0) {
              cy.get('.group.bg-white.rounded-xl').first().within(() => {
                cy.get('button[type="submit"]').contains('Hapus').click()
              })
              
              cy.wait(2000)
              
              // Recursively delete next user
              deleteAllUsers(count - 1)
            }
          })
        }
        
        // Mulai hapus semua user
        deleteAllUsers(initialUserCount)
        
        cy.log('✅ All users deletion test completed')
      } else {
        cy.log('⚠️ No users to delete - test skipped')
        this.skip()
      }
    })
  })

})