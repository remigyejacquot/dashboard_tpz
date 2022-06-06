<template>
  <div
    style="width: 22%; border-radius: 15px"
    class="bg-white p-4 align-items-center d-flex flex-column"
  >
    <h3>entreprise3Z</h3>
    <div class="mb-2 d-flex align-items-center">
      <span> 5 </span>
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        stroke-width="2"
        width="20px"
        height="20px"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
        />
      </svg>
    </div>
    <div class="mt-1">
      <p class="p-1 m-0">Julie Petit</p>
      <p class="p-1 m-0">Julie Petit</p>
      <p class="p-1 m-0">Julie Petit</p>
      <p class="p-1 m-0">Julie Petit</p>
      <p class="p-1 m-0">Julie Petit</p>
    </div>
    <div>
      <p class="mb-1 mt-3">Projet(s): 2</p>
      <div class="border border-warning border-4 rounded rounded-4">
        <div
          class="border-bottom border-warning border-4 p-2 d-flex align-items-center gap-2 justify-content-between"
        >
          <div class="d-flex gap-2 align-items-center">
            <span
              style="width: 10px; height: 10px; background-color: green"
              class="rounded-circle d-inline-block me-2"
            />
            <h5 class="d-inline-block m-0">Projet flyers</h5>
          </div>
          <div>
            <span style="justify-self: flex-end">14%</span>
          </div>
        </div>
        <div class="p-3">
          <div class="d-flex align-items-center justify-content-between">
            <div class="progress" style="width: 75%">
              <div
                class="progress-bar"
                role="progressbar"
                aria-valuenow="0"
                aria-valuemin="0"
                aria-valuemax="100"
              ></div>
            </div>
            <span class="d-block" style="width: 20%">30%</span>
          </div>
          <div class="d-flex align-items-center mt-2">
            <div>
              <span class="d-block">Date</span>
              <p style="font-size: 14px">Création de la carte graphique</p>
            </div>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              style="width: 15px; height: 15px"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
              />
            </svg>
          </div>
          <div class="d-flex align-items-center">
            <div>
              <span class="d-block">Date</span>
              <p style="font-size: 14px" class="m-0">
                Création de la carte graphique
              </p>
            </div>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              style="width: 15px; height: 15px"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M5 13l4 4L19 7"
              />
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProjectPreview",
};
</script>
