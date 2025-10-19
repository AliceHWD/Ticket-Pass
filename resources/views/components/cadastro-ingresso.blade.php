<form id="salesForm" method="POST" action="/events">
    <section class="tickets">
        <h2>Ingressos</h2>
        <div class="form-group">
            <label for="ticketType">Selecione o tipo do ingresso</label>
            <select id="ticketType" required>
                <option value="">Selecione o tipo</option>
                <option value="inteira">Inteira</option>
                <option value="meia">Meia</option>
            </select>
        </div>

        <div class="form-group">
            <label for="ticketQuantity">Quantidade de ingressos</label>
            <input type="number" id="ticketQuantity" min="1" required>
        </div>

        <div class="form-group">
            <label for="ticketPrice">Valor que deseja vender</label>
            <input type="number" id="ticketPrice" min="0" step="0.01" required>
        </div>

        <div class="total">
            <p>Total a receber: R$<span id="totalAmount">0.00</span></p>
        </div>
    </section>

    <div class="button-container">
        <button type="submit" id="announceButton">Anunciar</button>
    </div>
</form>
