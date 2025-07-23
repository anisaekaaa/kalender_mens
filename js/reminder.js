const siklusTerakhirMulai = new Date('2025-07-01'); 
const durasiMenstruasi = 5;
const siklusTotal = 28; 

const hariIni = new Date();
hariIni.setHours(0,0,0,0);

function isMenstruasi() {
  const diff = Math.floor((hariIni - siklusTerakhirMulai) / (1000 * 60 * 60 * 24));
  const pos = diff % siklusTotal;
  return pos >= 0 && pos < durasiMenstruasi;
}

function isMasaSubur() {
  const diff = Math.floor((hariIni - siklusTerakhirMulai) / (1000 * 60 * 60 * 24));
  const pos = diff % siklusTotal;
  return pos >= 11 && pos <= 15;
}

function showReminder(message, color) {
  let reminderDiv = document.getElementById('reminder-banner');
  if (!reminderDiv) {
    reminderDiv = document.createElement('div');
    reminderDiv.id = 'reminder-banner';
    reminderDiv.style.position = 'fixed';
    reminderDiv.style.top = '0';
    reminderDiv.style.left = '0';
    reminderDiv.style.width = '100%';
    reminderDiv.style.padding = '15px';
    reminderDiv.style.textAlign = 'center';
    reminderDiv.style.color = 'white';
    reminderDiv.style.fontWeight = 'bold';
    reminderDiv.style.zIndex = '9999';
    document.body.prepend(reminderDiv);
  }
  reminderDiv.style.backgroundColor = color;
  reminderDiv.textContent = message;
}

if (isMenstruasi()) {
  showReminder('🩸 Hari ini kamu sedang masa menstruasi. Jangan lupa jaga kesehatan ya!');
} else if (isMasaSubur()) {
  showReminder('🌱 Hari ini masa suburmu. Semoga harimu menyenangkan!');
}