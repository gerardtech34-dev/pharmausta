<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Nouveau message de contact</title>
</head>
<body style="font-family: Arial, sans-serif; background: #F8F9FA; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background: #ffffff; border-radius: 8px; padding: 30px; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
        <div style="text-align: center; margin-bottom: 30px;">
            <span style="font-size: 28px; font-weight: bold; color: #4B2E83;">PharmaUSTA</span>
        </div>
        <h2 style="color: #4B2E83; margin-bottom: 20px;">Nouveau message de contact</h2>
        <p><strong>Nom :</strong> {{ $nom }}</p>
        <p><strong>Email :</strong> {{ $emailExpediteur }}</p>
        <p><strong>Sujet :</strong> {{ $sujet }}</p>
        <hr style="margin: 20px 0;">
        <p style="white-space: pre-line;">{{ $contenuMessage }}</p>
        <hr style="margin: 20px 0;">
        <p style="color: #666; font-size: 12px; text-align: center;">Message envoyé depuis PharmaUSTA</p>
    </div>
</body>
</html>
