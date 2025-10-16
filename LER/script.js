
    // Variables globales para las partículas
    let points = [];
    let canvas, ctx;
    const maxDist = 100;

    // --- Funcionalidad de Modo Oscuro ---
    const body = document.body;
    const toggleBtn = document.getElementById("toggle-btn");

    // Verificar preferencia guardada en localStorage al cargar la página
    const darkMode = localStorage.getItem("dark-mode");

    if (darkMode === "enabled") {
      body.classList.add("dark-mode");
      toggleBtn.textContent = "˗ˏˋ ☀︎ ˎˊ˗";
      toggleBtn.title = "Activar modo claro";
      // Inicializar partículas blancas para modo oscuro
      setTimeout(() => updateParticlesColor(true), 100);
    } else {
      // Inicializar partículas moradas para modo claro
      setTimeout(() => updateParticlesColor(false), 100);
    }

    // Evento de click en el botón para alternar el modo
    toggleBtn.addEventListener("click", () => {
      body.classList.toggle("dark-mode");

      if (body.classList.contains("dark-mode")) {
        toggleBtn.textContent = "˗ˏˋ ☀︎ ˎˊ˗";
        toggleBtn.title = "Activar modo claro";
        localStorage.setItem("dark-mode", "enabled");
        // Cambiar partículas a blanco
        updateParticlesColor(true);
      } else {
        toggleBtn.textContent = "⭒˚.⋆☪˚.⋆";
        toggleBtn.title = "Activar modo oscuro";
        localStorage.setItem("dark-mode", "disabled");
        // Cambiar partículas a morado
        updateParticlesColor(false);
      }
    });

    // Función para actualizar el color de las partículas
    function updateParticlesColor(isDarkMode) {
      if (points.length > 0) {
        points.forEach(point => {
          if (isDarkMode) {
            // Modo oscuro: partículas blancas
            point.fill = "rgba(255, 255, 255," + ((0.5 * Math.random()) + 0.5) + ")";
          } else {
            // Modo claro: partículas moradas
            point.fill = "rgba(142, 45, 226," + ((0.5 * Math.random()) + 0.5) + ")";
          }
        });
      }
    }

    // --- Funcionalidad de Fondo Animado (Partículas) ---
    (function () {
      'use strict';

      // Función de inicialización
      function init() {
        canvas = document.getElementById("canvas");
        ctx = canvas.getContext("2d");
        resizeCanvas();
        generatePoints(700);
        pointFun();
        setInterval(pointFun, 25);
        window.addEventListener('resize', resizeCanvas, false);
      }

      // Constructor de la partícula
      function point() {
        this.x = Math.random() * (canvas.width + maxDist) - (maxDist / 2);
        this.y = Math.random() * (canvas.height + maxDist) - (maxDist / 2);
        this.z = (Math.random() * 0.5) + 0.5;
        this.vx = ((Math.random() * 2) - 0.5) * this.z;
        this.vy = ((Math.random() * 1.5) + 1.5) * this.z;
        
        // Color inicial según el modo actual
        if (body.classList.contains("dark-mode")) {
          this.fill = "rgba(255, 255, 255," + ((0.5 * Math.random()) + 0.5) + ")"; // Blanco para modo oscuro
        } else {
          this.fill = "rgba(142, 45, 226," + ((0.5 * Math.random()) + 0.5) + ")"; // Morado para modo claro
        }
        
        this.dia = ((Math.random() * 2.5) + 1.5) * this.z;
        points.push(this);
      }

      // Generador de partículas
      function generatePoints(amount) {
        for (var i = 0; i < amount; i++) {
          new point();
        }
      }

      // Dibujador de partículas
      function draw(obj) {
        ctx.beginPath();
        ctx.strokeStyle = "transparent";
        ctx.fillStyle = obj.fill;
        ctx.arc(obj.x, obj.y, obj.dia, 0, 2 * Math.PI);
        ctx.closePath();
        ctx.stroke();
        ctx.fill();
      }

      // Actualizador de posición de partículas
      function update(obj) {
        obj.x += obj.vx;
        obj.y += obj.vy;

        if (obj.x > canvas.width + (maxDist / 2)) {
          obj.x = -(maxDist / 2);
        } else if (obj.x < -(maxDist / 2)) {
          obj.x = canvas.width + (maxDist / 2);
        }
        if (obj.y > canvas.height + (maxDist / 2)) {
          obj.y = -(maxDist / 2);
        } else if (obj.y < -(maxDist / 2)) {
          obj.y = canvas.height + (maxDist / 2);
        }
      }

      // Función principal de animación
      function pointFun() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        for (var i = 0; i < points.length; i++) {
          draw(points[i]);
          update(points[i]);
        }
      }

      // Ajustar el tamaño del canvas
      function resizeCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        pointFun();
      }

      // Ejecutar la función init cuando el DOM esté completamente cargado
      document.addEventListener('DOMContentLoaded', init, false);
    })();
