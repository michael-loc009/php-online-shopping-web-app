<div class="container">
  <div class="container border px-3 py-3">
    <p class="h1 text-center" id="error">ADD NEW PRODUCT</p>
    <div class="mb-3 row">
      <div class="col">
        <label for="label" class="form-label">Name (*)</label>
        <input
          type="text"
          class="form-control"
          id="inputName"
          aria-describedby="emailHelp"
          minlength="10"
          maxlength="20"
          required
        />
      </div>
      <div class="col">
        <label for="exampleInputEmail1" class="form-label">Price (*)</label>
        <input
          type="number"
          min="0.00"
          max="100000.00"
          step="0.01"
          class="form-control"
          id="inputPrice"
          pattern="[+]?[0-9]"
          aria-describedby="emailHelp"
          require
        />
      </div>
    </div>
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label"
        >Description</label
      >
      <textarea class="form-control" id="inputDescription" rows="3"></textarea>
    </div>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label"
        >Product Image (*)</label
      >
      <input
        type="file"
        class="form-control"
        id="inputGetFile"
        accept="image/*"
      />
    </div>
    <button
      type="submit"
      class="btn btn-primary"
      id="#btn-submit"
      onclick="validation(event)"
    >
      Submit
    </button>
  </div>
</div>
