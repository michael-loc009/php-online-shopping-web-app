<div class="container">
  <div class="container border px-3 py-3">
    <p class="h1 text-center">ADD NEW PRODUCT</p>
    <p class="h7 text-danger" id="error"></p>
    <div class="mb-3 row">
      <div class="col">
        <label class="form-label">Name (*)</label>
        <input
          type="text"
          class="form-control"
          id="inputName"
          minlength="10"
          maxlength="20"
        />
      </div>
      <div class="col">
        <label class="form-label">Price (*)</label>
        <input
          type="number"
          min="0.00"
          max="100000.00"
          step="0.01"
          class="form-control"
          id="inputPrice"
        />
      </div>
    </div>
    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea class="form-control" id="inputDescription" rows="3"></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Product Image (*)</label>
      <input
        type="file"
        class="form-control"
        id="inputGetFile"
        accept="image/png, image/jpeg, image/jpg"
      />
    </div>
    <button
      type="submit"
      class="btn btn-primary"
      id="#btn-submit"
      onclick="_addProduct(event)"
    >
      Submit
    </button>
  </div>
</div>
