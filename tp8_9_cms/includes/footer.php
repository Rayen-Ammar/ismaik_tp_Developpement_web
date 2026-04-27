<?php
/*
 * FICHIER : includes/footer.php
 * RÔLE : Pied de page global. Ce fichier vient clôturer les balises HTML principales
 * ouvertes dans header.php (comme </main>, </body> et </html>) et affiche le copyright.
 */
?>
<!-- Fermeture du conteneur principal de la page ouvert dans header.php -->
</main>

<!-- Bloc du pied de page (footer) -->
<footer class="footer glass"
    style="margin-top: auto; padding: 25px 0; border-top: 1px solid var(--glass-border); border-left: none; border-right: none; border-bottom: none; border-radius: 0;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 24px; text-align: center; color: var(--text-muted);">
        <!-- Affichage dynamique de l'année actuelle avec la fonction date("Y") PHP -->
        <p>&copy; <?= date("Y") ?> NexGen CMS. Développé par Ammar Rayen. <i class="fa-solid fa-code"
                style="color:var(--primary);"></i></p>
    </div>
</footer>

<!-- Fin totale du document HTML -->
</body>

</html>