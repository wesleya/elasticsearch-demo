<form class="form" v-on:submit.prevent="loadNew">
    <div class="form-group">
        <label for="inlineFormCustomSelect">Product Type</label>
        <select id="product_type" class="form-control" v-on:change="loadNew" v-model="product_type">
            <option value="0" selected>Choose...</option>
            <option value="1">Bank</option>
            <option value="2">Credit Card</option>
            <option value="3">Money Transfer</option>
            <option value="4">Loan</option>
            <option value="5">Mortgage</option>
            <option value="6">Debt Collection</option>
        </select>
    </div>
</form>