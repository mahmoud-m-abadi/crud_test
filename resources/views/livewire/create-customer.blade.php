<div>
    <div class="mb-2 bg-black/50 border border-red-400 text-white px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Create Customer</strong>
        <span class="block sm:inline">you can create a new customer here.</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
      </span>
    </div>
    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <button type="submit" class="w-full mt-2 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
            Submit
        </button>
    </form>
</div>
