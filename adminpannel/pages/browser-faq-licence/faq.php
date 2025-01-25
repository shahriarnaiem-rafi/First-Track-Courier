<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 20px;
    }

    .faq-container {
        max-width: 800px;
        margin: 50px auto;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .faq-item {
        margin-bottom: 15px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }

    .faq-question {
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .faq-answer {
        display: none;
        margin-top: 10px;
        font-size: 16px;
        color: #555;
    }

    .faq-question span {
        font-size: 20px;
        color: #007bff;
    }

    .faq-question span.open {
        transform: rotate(180deg);
    }
</style>



<div class="faq-container">
    <h2>Frequently Asked Questions</h2>
    <div class="faq-item">
        <div class="faq-question">
            <span>What is this platform about?</span>
            <span class="toggle">+</span>
        </div>
        <div class="faq-answer">
            <p>This platform is designed to streamline courier and delivery services by allowing customers to manage
                shipments efficiently.</p>
        </div>
    </div>
    <div class="faq-item">
        <div class="faq-question">
            <span>How do I track my shipment?</span>
            <span class="toggle">+</span>
        </div>
        <div class="faq-answer">
            <p>You can track your shipment by entering your tracking number in the tracking section of our website.
            </p>
        </div>
    </div>
    <div class="faq-item">
        <div class="faq-question">
            <span>What payment methods do you accept?</span>
            <span class="toggle">+</span>
        </div>
        <div class="faq-answer">
            <p>We accept various payment methods including credit cards, PayPal, and cash on delivery.</p>
        </div>
    </div>
    <div class="faq-item">
        <div class="faq-question">
            <span>How do I contact support?</span>
            <span class="toggle">+</span>
        </div>
        <div class="faq-answer">
            <p>You can reach out to our support team through the contact page or via email at support@example.com.
            </p>
        </div>
    </div>
</div>

<script>
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        const toggle = item.querySelector('.toggle');

        question.addEventListener('click', () => {
            const isOpen = answer.style.display === 'block';
            answer.style.display = isOpen ? 'none' : 'block';
            toggle.textContent = isOpen ? '+' : '−';
        });
    });
</script>