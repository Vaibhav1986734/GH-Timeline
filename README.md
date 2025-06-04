# 📬 GH-Timeline: Email Verification and GitHub Timeline Updates

A PHP-based email verification system that allows users to register using their email and receive GitHub timeline updates via email. Includes a CRON job for periodic updates, an unsubscribe mechanism, and a modern user interface with modal-based feedback.

---

## 🚀 Features

- 📧 Email subscription with verification code
- 🔐 6-digit email verification system
- 📨 Emails sent using SMTP (e.g., Mailtrap or any SMTP provider)
- ⏱ CRON job fetches GitHub timeline every 5 minutes and sends to subscribers
- 🔕 Unsubscribe via verification and confirmation
- 💡 All alerts/messages displayed in Bootstrap modal popups
- ✨ Beautiful animated UI using Bootstrap 5 + AOS.js

---

## 🛠️ Technologies Used

| Platform     | Purpose                      |
|--------------|-------------------------------|
| PHP 8.x+     | Backend logic, sessions, email |
| Bootstrap 5  | Responsive UI design           |
| AOS.js       | UI animations on load/scroll   |
| CRON         | Scheduled GitHub timeline fetch |
| Mailtrap.io  | SMTP email sending (dev use)   |

---

