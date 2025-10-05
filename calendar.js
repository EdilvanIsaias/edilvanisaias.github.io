function abrirAgendamento(tipo) {
  const secao = document.getElementById('calendar-section');
  secao.style.display = 'block';
  window.scrollTo({ top: secao.offsetTop, behavior: 'smooth' });
  gerarCalendario(tipo);
}

function gerarCalendario(tipo) {
  const placeholder = document.getElementById("calendar-placeholder");
  placeholder.innerHTML = "";

  const hoje = new Date();
  const dias = 14; // mostra próximos 14 dias
  const horarios = ["09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30"];

  const calendario = document.createElement("div");
  calendario.classList.add("grid-calendario");

  for (let i = 0; i < dias; i++) {
    const data = new Date(hoje);
    data.setDate(hoje.getDate() + i);

    const diaDiv = document.createElement("div");
    diaDiv.classList.add("dia-calendario");

    const titulo = document.createElement("h4");
    titulo.textContent = data.toLocaleDateString('pt-BR', { weekday: 'short', day: '2-digit', month: 'short' });
    diaDiv.appendChild(titulo);

    horarios.forEach(hora => {
      const botao = document.createElement("button");
      botao.textContent = hora;
      botao.classList.add("btn-horario");
      botao.onclick = () => {
        alert(`Consulta ${tipo} agendada para ${data.toLocaleDateString()} às ${hora}.`);
      };
      diaDiv.appendChild(botao);
    });

    calendario.appendChild(diaDiv);
  }

  placeholder.appendChild(calendario);
}

// CSS dinâmico para o calendário
const estilo = document.createElement('style');
estilo.textContent = `
.grid-calendario {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 1.5rem;
}

.dia-calendario {
  background: #f8f9fa;
  padding: 1rem;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.dia-calendario h4 {
  text-align: center;
  color: #024873;
  margin-bottom: 0.5rem;
}

.btn-horario {
  display: block;
  width: 100%;
  padding: 0.5rem;
  margin-bottom: 0.3rem;
  background-color: #198754;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.2s ease;
}

.btn-horario:hover {
  background-color: #157347;
}
`;
document.head.appendChild(estilo);
