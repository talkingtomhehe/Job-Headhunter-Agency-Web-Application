<main>
    <!-- Contact Page Header -->
    <section class="ct-header">
        <div class="container">
            <h1 class="ct-title">Contact Us</h1>
            <p class="ct-subtitle">We're just a message away! Whether you have questions about our services, need support, or want to partner with us, our team is here for you.</p>
        </div>
    </section>

    <!-- Contact Information and Map Section -->
    <section class="ct-content-section">
        <div class="container ct-container">
            <div class="ct-details-container">
                <div class="ct-details-card">
                    <h2 class="ct-section-title">Get In Touch</h2>
                    
                    <div class="ct-info-item">
                        <div class="ct-icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div class="ct-text">
                            <h3>Our Office</h3>
                            <p>269 Ly Thuong Kiet, District 11</p>
                            <p>Ho Chi Minh City, Vietnam</p>
                        </div>
                    </div>
                    
                    <div class="ct-info-item">
                        <div class="ct-icon">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div class="ct-text">
                            <h3>Phone Number</h3>
                            <p><a href="tel:+84901234567">+84 90 123 4567</a></p>
                            <p><a href="tel:+84283812345">+84 28 381 2345</a></p>
                        </div>
                    </div>
                    
                    <div class="ct-info-item">
                        <div class="ct-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div class="ct-text">
                            <h3>Email Address</h3>
                            <p><a href="mailto:info@huntly.com">info@huntly.com</a></p>
                            <p><a href="mailto:support@huntly.com">support@huntly.com</a></p>
                        </div>
                    </div>
                    
                    <div class="ct-info-item">
                        <div class="ct-icon">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div class="ct-text">
                            <h3>Office Hours</h3>
                            <p>Monday - Friday: 8:00 AM - 5:00 PM</p>
                            <p>Saturday: 9:00 AM - 12:00 PM</p>
                        </div>
                    </div>
                    
                    <div class="ct-social-links">
                        <h3>Follow Us</h3>
                        <div class="ct-social-icons">
                            <a href="#" class="ct-social-icon"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#" class="ct-social-icon"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#" class="ct-social-icon"><i class="fa-brands fa-linkedin-in"></i></a>
                            <a href="#" class="ct-social-icon"><i class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="ct-map-container">
                <div class="ct-map-wrapper">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.495241260917!2d106.65471010880792!3d10.773330259210146!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ec16cfbe659%3A0x7ee4592d7ebfc676!2zMjY5IMSQLiBMw70gVGjGsOG7nW5nIEtp4buHdCwgUGjGsOG7nW5nIDE1LCBRdeG6rW4gMTEsIEjhu5MgQ2jDrSBNaW5oLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1744771480677!5m2!1svi!2s" 
                        width="600" 
                        height="450" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        class="ct-google-map">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Contact Form Section -->
    <section class="ct-form-section">
        <div class="container">
            <h2 class="ct-section-title">Send Us a Message</h2>
            <form class="ct-form">
                <div class="ct-form-row">
                    <div class="ct-form-group">
                        <label for="name">Your Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your name" required>
                    </div>
                    <div class="ct-form-group">
                        <label for="email">Your Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                </div>
                <div class="ct-form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" placeholder="Enter subject">
                </div>
                <div class="ct-form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="5" placeholder="Enter your message" required></textarea>
                </div>
                <button type="submit" class="ct-submit-btn">Send Message</button>
            </form>
        </div>
    </section>
</main>

<style>
/* Contact Page Styles with ct- prefix to avoid conflicts */
.ct-header {
    color: #0631BC;
    padding: 100px 0 50px;
    text-align: center;
    margin-top: 0;
}

.ct-title {
    font-size: 2.8rem;
    font-weight: 700;
    margin-bottom: 1.2rem;
    position: relative;
    display: inline-block;
}

.ct-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background-color: #0631BC;
    border-radius: 2px;
}

.ct-subtitle {
    font-size: 1.15rem;
    max-width: 700px;
    margin: 1.8rem auto 0;
    line-height: 1.6;
    color: #0631BC;
}

@media (max-width: 768px) {
    .ct-title {
        font-size: 2.2rem;
    }
    
    .ct-subtitle {
        font-size: 1.05rem;
        padding: 0 15px;
    }
}

.ct-content-section {
    padding-top: -30px;
}

.ct-container {
    display: flex;
    flex-direction: row;
    align-items: stretch;
    margin: 50px auto;
    flex-wrap: wrap;
}

.ct-details-container {
    flex: 1;
    min-width: 300px;
    padding: 20px;
}

.ct-details-card {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    padding: 30px;
    height: 100%;
}

.ct-section-title {
    font-size: 1.8rem;
    color: #0631BC;
    margin-bottom: 25px;
    position: relative;
    padding-bottom: 15px;
}

.ct-section-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 3px;
    background-color: #0631BC;
    border-radius: 2px;
}

.ct-info-item {
    display: flex;
    margin-bottom: 25px;
}

.ct-icon {
    width: 50px;
    height: 50px;
    background-color: #E1F3FB;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    flex-shrink: 0;
}

.ct-icon i {
    color: #0631BC;
    font-size: 1.2rem;
}

.ct-text h3 {
    font-size: 1.1rem;
    margin-bottom: 5px;
    color: #333;
}

.ct-text p {
    margin: 0 0 5px 0;
    color: #666;
    font-size: 0.95rem;
}

.ct-text a {
    color: #666;
    text-decoration: none;
    transition: color 0.3s;
}

.ct-text a:hover {
    color: #0631BC;
}

.ct-social-links h3 {
    font-size: 1.1rem;
    margin-bottom: 15px;
    color: #333;
}

.ct-social-icons {
    display: flex;
    gap: 10px;
}

.ct-social-icon {
    width: 40px;
    height: 40px;
    background-color: #E1F3FB;
    color: #0631BC;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s;
}

.ct-social-icon:hover {
    background-color: #0631BC;
    color: white;
    transform: translateY(-3px);
}

.ct-map-container {
    flex: 1;
    min-width: 300px;
    padding: 20px;
}

.ct-map-wrapper {
    height: 100%;
    min-height: 400px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

.ct-google-map {
    width: 100%;
    height: 100%;
    border: none;
}

.ct-form-section {
    background-color: #f8f9fa;
    padding: 50px 0 70px;
}

.ct-form-section .container {
    max-width: 800px;
    flex-direction: column;
}

.ct-form-section .ct-section-title {
    align-self: flex-start;
    margin-bottom: 20px;
}

.ct-form {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    padding: 30px;
    width: 100%;
}

.ct-form-row {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.ct-form-group {
    flex: 1;
    min-width: 250px;
    margin-bottom: 20px;
}

.ct-form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #333;
}

.ct-form-group input,
.ct-form-group textarea {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
    transition: border-color 0.3s;
    font-family: inherit;
}

.ct-form-group input:focus,
.ct-form-group textarea:focus {
    border-color: #0631BC;
    outline: none;
}

.ct-submit-btn {
    background-color: #0631BC;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 12px 25px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s;
    font-family: inherit;
}

.ct-submit-btn:hover {
    background-color: #052592;
    transform: translateY(-2px);
}

/* Responsive Styles */
@media (max-width: 768px) {
    .ct-title {
        font-size: 2rem;
    }
    
    .ct-section-title {
        font-size: 1.5rem;
    }
    
    .ct-form-row {
        flex-direction: column;
        gap: 0;
    }
    
    .ct-map-wrapper {
        min-height: 300px;
    }
}
</style>