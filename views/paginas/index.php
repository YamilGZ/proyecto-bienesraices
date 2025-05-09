<main class="contenedor seccion">
        <h1>Más sobre Nosotros</h1>
        <?php include 'iconos.php'; ?>
    </main>

    <section class="seccion contenedor">
        <h2>Casas y Depas en Venta</h2>

        <?php
            include 'listado.php';
        ?>

        <div class="alinear-derecha">
            <a href="/propiedades" class="boton-verde">Ver Todas</a>
        </div>
    </section>

    <section class="imagen-contacto">
        <h2>Encuentra la casa de tus sueños</h2>
        <p>Llena el formulario de contacto y un asesor se prondrá en contacto contigo en la brevedad.</p>
        <a href="/contacto" class="boton-amarillo">Contactános</a>
    </section>

    <div class="contenedor seccion seccion-inferior">
        <section class="blog">
            <h3>Nuestro Blog</h3>

            <article class="entrada-blog">
                <div class="imagen">
                    <picture>
                        <source srcset="build/img/blog1.webp" type="image/webp">
                        <source srcset="build/img/blog1.jpg" type="image/jpeg">
                        <img src="build/img/blog1.jpg" alt="texto entrada blog" loading="lazy">
                    </picture>
                </div>
                <div class="texto-entrada">
                    <a href="/entrada">
                    <h4>Terraza en el techo de tu casa</h4>
                    </a>
                    <p class="informacion-meta">Escrito el: <span>06/10/2023</span> por: <span>Yamil Zaracho</span></p>
                    <p>
                        Consejos para construir una terraza en el techo de su casa
                        con los mejores materiales y ahorrando dinero.
                    </p>
                </div>
            </article>
            <article class="entrada-blog">
                <div class="imagen">
                    <picture>
                        <source srcset="build/img/blog2.webp" type="image/webp">
                        <source srcset="build/img/blog2.jpg" type="image/jpeg">
                        <img src="build/img/blog2.jpg" alt="texto entrada blog" loading="lazy">
                    </picture>
                </div>
                <div class="texto-entrada">
                    <a href="/entrada">
                    <h4>Guia para la decoracion de tu hogar</h4>
                    </a>
                    <p class="informacion-meta">Escrito el: <span>06/10/2023</span> por: <span>Juan de la Torre</span></p>
                    <p>
                        Maximiza el espacio en tu hogar con esta guia, aprende a
                        cambiar muebles y colores para darle vida a tu espacio.
                    </p>
                </div>
            </article>
        </section>

        <section class="testimoniales">
            <h3>Testimoniales</h3>
            
            <div class="testimonial">

                <blockquote>
                    El personal se comportó de una excelente forma, muy buena atencíon
                    y la casa que me ofrecieron cumple con todas mis expectativas.
                </blockquote>
                <p>- Naila Baez</p>
            
            </div>
        </section>

    </div>