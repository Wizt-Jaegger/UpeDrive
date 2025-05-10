<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<style>
  #comentarioForm input::placeholder,
  #comentarioForm textarea::placeholder {
    color: #f5f5f5;
    opacity: 1;
  }
</style>

<section class="client_section layout_padding" section id="testimonios">
  <div class="container">
    <div class="heading_container heading_center">
      <h2>Testimonios de nuestros clientes</h2>
    </div>

    <div id="testimoniosCarousel" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner" id="comentariosCarousel">
        <!-- Comentarios se llenarán por JS -->
      </div>

      <div class="carousel_btn_box">
        <a class="carousel-control-prev" href="#testimoniosCarousel" role="button" data-slide="prev">
          <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
        </a>
        <a class="carousel-control-next" href="#testimoniosCarousel" role="button" data-slide="next">
          <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
        </a>
      </div>
    </div>

    <div class="comment_form mt-5">
      <div class="heading_container heading_center">
        <h4>Deja tu comentario</h4>
      </div>
      <form id="comentarioForm" class="mt-3">
        <div class="form-group">
          <label for="nombre">Nombre:</label>
          <input 
            type="text" 
            class="form-control" 
            id="nombre" 
            name="nombre" 
            required 
            placeholder="Ingresa tu nombre"
            style="background-color:rgba(255,255,255,0.5); border-radius:20px; color:#fff; ::placeholder{color:#f5f5f5; opacity:1;}"
          >
        </div>
        <div class="form-group">
          <label for="mensaje">Comentario:</label>
          <textarea 
            class="form-control" 
            id="mensaje" 
            name="mensaje" 
            rows="4" 
            required 
            placeholder="Escribe tu experiencia"
            style="background-color:rgba(255,255,255,0.5); border-radius:20px; color:#fff; ::placeholder{color:#f5f5f5; opacity:1;}"
          ></textarea>
        </div>
        <button style= "backgroud-color: #0fa5ae; border-radius:20px;"type="submit" class="btn btn-primary">Enviar comentario</button>
        <p id="resultado" class="mt-2"></p>
      </form>


    </div>
  </div>
</section>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const carouselInner = document.getElementById("comentariosCarousel");

    fetch("https://d1-jellyfun.vilfront.workers.dev/api/posts/hello-world/comments")
      .then(response => response.json())
      .then(data => {
        if (!data || !data.length) return;

        data.forEach((comentario, index) => {
          const activeClass = index === 0 ? 'active' : '';
          const item = `
            <div class="carousel-item ${activeClass}">
              <div class="box col-lg-10 mx-auto">
                <div class="detail-box">
                  <h5>${comentario.author}</h5>
                  <h6>Usuario de la plataforma</h6>
                  <p>${comentario.body}</p>
                </div>
              </div>
            </div>
          `;
          carouselInner.insertAdjacentHTML('beforeend', item);
        });
      })
      .catch(error => console.error("Error cargando comentarios:", error));

    const form = document.getElementById("comentarioForm");
    const resultado = document.getElementById("resultado");

    form.addEventListener("submit", async function (e) {
      e.preventDefault();
      const nombre = form.nombre.value;
      const mensaje = form.mensaje.value;
      resultado.textContent = "Enviando...";

      try {
        const response = await fetch("https://d1-jellyfun.vilfront.workers.dev/api/posts/hello-world/comments", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            author: nombre,
            body: mensaje
          })
        });

        if (response.ok) {
          resultado.textContent = "¡Comentario enviado con éxito!";
          form.reset();
        } else {
          resultado.textContent = "Ocurrió un error al enviar el comentario.";
        }
      } catch (error) {
        console.error("Error al enviar:", error);
        resultado.textContent = "Error de conexión con el servidor.";
      }
    });
  });
</script>

