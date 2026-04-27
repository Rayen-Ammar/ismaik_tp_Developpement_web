

document.addEventListener('DOMContentLoaded', () => {
   
    
    
    const studentForm = document.getElementById('student-form');
    
    
    const nomInput = document.getElementById('nom');
    const prenomInput = document.getElementById('prenom');
    const emailInput = document.getElementById('email');
    
    
    const studentList = document.getElementById('student-list');
    const tableContainer = document.querySelector('.table-container');
    const emptyMessage = document.getElementById('empty-message');
    
    
    const messageContainer = document.getElementById('message-container');

   
    
    studentForm.addEventListener('submit', (event) => {
        
        event.preventDefault();

        
        const nom = nomInput.value.trim();
        const prenom = prenomInput.value.trim();
        const email = emailInput.value.trim();

        
        messageContainer.textContent = '';
        messageContainer.className = '';

        
        
        
       
        if (nom === '' || prenom === '' || email === '') {
            displayMessage("Veuillez remplir tous les champs.", "error-msg");
            
            
            if (nom === '') {
                nomInput.focus();
            } else if (prenom === '') {
                prenomInput.focus();
            } else {
                emailInput.focus();
            }
            return;
        }

        
        if (!validateEmail(email)) {
            displayMessage("Veuillez saisir un email valide.", "error-msg");
            emailInput.focus();
            return;
        }

        const row = document.createElement('tr');

        
        const cellNom = document.createElement('td');
        cellNom.textContent = nom;
        
        const cellPrenom = document.createElement('td');
        cellPrenom.textContent = prenom;

        const cellEmail = document.createElement('td');
        cellEmail.textContent = email;

        
        row.appendChild(cellNom);
        row.appendChild(cellPrenom);
        row.appendChild(cellEmail);

       
        studentList.appendChild(row);

        tableContainer.classList.add('show');
        emptyMessage.classList.add('hide');

        
        displayMessage("Étudiant ajouté avec succès !", "success-msg");
        
        
        studentForm.reset();
        
        
        nomInput.focus();
    });

    
    
    /**
     * Fonction pour afficher les messages d'erreur ou de succès
     * @param {string} text - Le texte du message
     * @param {string} className - La classe CSS (error-msg ou success-msg)
     */
    function displayMessage(text, className) {
        messageContainer.textContent = text;
        messageContainer.className = className;
    }

    /**
     * Fonction de validation d'email simple
     * @param {string} email - L'email à valider
     * @returns {boolean} - True si l'email est valide, false sinon
     */
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
});
