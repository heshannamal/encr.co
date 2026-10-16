
<div id="projectModal" class="modal">
    <div class="modal-content">
        <span id="closeModal">&times;</span>
        <h3>ADD PROJECT</h3>

        <div class="step-header">
            <div class="step active" style="z-index: 5; background: linear-gradient(to right, #464646, #1c1c1c); color: #fff;" data-step="1" >NEW PROJECT</div>
            <div class="step" data-step="2">PROJECT TYPE</div>
            <div class="step" data-step="3">PROJECT CREATE</div>
        </div>

        <form id="projectForm" action="{{ route('new_projects.create_temp') }}" method="POST">
            @csrf
            <!-- STEP 1 -->
            <div class="step-content step-1 active">
                <h4>Select Project Type</h4>

                <div class="radio-row">
                    @foreach ($type as $projectType)
                        <label for="project_type_{{ $projectType->id }}" class="font_14_gray"><input type="radio" name="project_type" id="project_type_{{ $projectType->id }}" value="{{ $projectType->id }}" /> {{ $projectType->type_name }}</label>
                    @endforeach
                </div>

                <div class="btn-group" style="justify-content: flex-end;">
                    <button type="button" class="btn next-btn">Continue</button>
                </div>
                </div>

            <!-- STEP 2 -->
            <div class="step-content step-2">
                {{-- <h4>Step 2: Project Details</h4> --}}
                <div id="dynamicContentStep2"></div>
                <div class="btn-group">
                    <button type="button" class="btn back-btn">Back</button>
                    <button type="submit" class="btn next-btn">CREATE PROJECT</button>
                </div>
            </div>


            <!-- STEP 3 -->
            <div class="step-content step-3 text-center">
                <h4>The project is being created...</h4>
            </div>
        </form>
    </div>
</div>

  <script>
    
    const modal = document.getElementById("projectModal");
    const openBtn = document.getElementById("openModalBtn");
    const closeBtn = document.getElementById("closeModal");
    const nextBtns = document.querySelectorAll('.next-btn');
    const backBtns = document.querySelectorAll('.back-btn');
    const steps = document.querySelectorAll('.step');
    const contents = document.querySelectorAll('.step-content');
    const step2Content = document.getElementById('dynamicContentStep2');

    let currentStep = 1;
    let selectedType = '1'; // default

    // Detect selection change in step 1
    const typeRadios = document.querySelectorAll('input[name="project_type"]');
    typeRadios.forEach(radio => {
      radio.addEventListener('change', () => {
        selectedType = radio.value;
      });
    });

    openBtn.addEventListener("click", () => {
      modal.style.display = "flex";
      showStep(currentStep);
    });

    closeBtn.addEventListener("click", () => {
      modal.style.display = "none";
      currentStep = 1;
      showStep(currentStep);
    });

    window.addEventListener("click", (e) => {
      if (e.target === modal) {
        modal.style.display = "none";
        currentStep = 1;
        showStep(currentStep);
      }
    });

    nextBtns.forEach(btn => {
      btn.addEventListener("click", () => {
        if (currentStep < 3) {
          currentStep++;
          if (currentStep === 2) {
            renderStep2Content(selectedType);
          }
          showStep(currentStep);
        }
      });
    });

    backBtns.forEach(btn => {
      btn.addEventListener("click", () => {
        if (currentStep > 1) {
          currentStep--;
          showStep(currentStep);
        }
      });
    });

    function showStep(step) {
      contents.forEach(c => c.classList.remove('active'));
      steps.forEach(s => s.classList.remove('active'));

      document.querySelector(`.step-${step}`).classList.add('active');
      document.querySelector(`.step[data-step="${step}"]`).classList.add('active');
    }

    

    function renderStep2Content(type) {
        let html = '';
        switch (type) {
            case '1':
            html = `<h4>Add Project Info</h4>
                        <div class="padding_top_bottom_10"> <span class="font_14_gray"> Project Name </span> </div>
                        <div> <input class="form-control" name="project_name" type="text" placeholder="Project one" style="width: 100%;" /> </div>

                        <div class="padding_top_bottom_10"> <span class="font_14_gray"> Project Status </span> </div>
                        <select class="form-select form-control" style="width: 100%;" name="project_status" id="project_status">
                            @foreach ($projectStatus as $projectStat)
                                <option value="{{ $projectStat->id }}">{{ $projectStat->status_name  }}</option>
                            @endforeach
                        </select>

                        <div class="padding_top_bottom_10"> <span class="font_14_gray"> Project description</span> </div>
                        <textarea class="form-control" name="project_description" placeholder="Add description" style="width: 100%; height: 80px;"></textarea>
                    `;
            break;
            case '2':html = `<h4>Product Status</h4>
                        <div class="radio-row">
                            <label class="font_14_gray">
                                <input type="radio" name="product_development_type" value="new_project" checked />
                                Create a new main product
                            </label>

                            <label class="font_14_gray">
                                <input type="radio" name="product_development_type" value="exist_project" />
                                Start with existing main product
                            </label>

                            <label class="font_14_gray">
                                <input type="radio" name="product_development_type" value="new_sub_product" />
                                Create a new sub product
                            </label>

                            <label class="font_14_gray">
                                <input type="radio" name="product_development_type" value="exist_sub_product" />
                                Start with existing sub product
                            </label>
                        </div>

                        <!-- Existing main product -->
                        <div id="existingProjectSelect" style="display:none; margin-top:10px;">
                            <div class="padding_top_bottom_10">
                                <span class="font_14_gray">Select a product</span>
                            </div>
                            <select class="form-select form-control new-select" name="product_for_create">
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->product_no }} - {{ $product->product_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- New sub product -->
                        <div id="subProductSelect" style="display:none; margin-top:10px;">
                            <div class="padding_top_bottom_10">
                                <span class="font_14_gray">What is the main product?</span>
                            </div>
                            <select class="form-select form-control new-select" name="main_product_id">
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->product_no }} - {{ $product->product_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Existing sub product -->
                        <div id="existingSubProductSelect" style="display:none; margin-top:10px;">
                            <div class="padding_top_bottom_10">
                                <span class="font_14_gray">Select a sub product</span>
                            </div>
                            <select class="form-select form-control new-select" name="sub_product_id">
                                @foreach ($subProducts as $subProduct)
                                    <option value="{{ $subProduct->id }}">
                                        {{ $subProduct->sub_product_no }} - {{ $subProduct->product_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    `;
            break;

            case '3':
            html = `<h4>Add Project Info</h4>
                        <div class="padding_top_bottom_10"> <span class="font_14_gray"> Project Name </span> </div>
                        <div> <input class="form-control" name="project_name" type="text" placeholder="Project one" style="width: 100%;" /> </div>

                        <div class="padding_top_bottom_10"> <span class="font_14_gray"> Project Status </span> </div>
                        <select class="form-select form-control" style="width: 100%;" name="project_status" id="project_status">
                            @foreach ($projectStatus as $projectStat)
                                <option value="{{ $projectStat->id }}">{{ $projectStat->status_name  }}</option>
                            @endforeach
                        </select>

                        <div class="padding_top_bottom_10"> <span class="font_14_gray"> Project description</span> </div>
                        <textarea class="form-control" name="project_description" placeholder="Add description" style="width: 100%; height: 80px;"></textarea>
                    `;
            break;
            case '4':
            html = `<h4>Add Project Info</h4>
                        <div class="padding_top_bottom_10"> <span class="font_14_gray"> Project Name </span> </div>
                        <div> <input class="form-control" name="project_name" type="text" placeholder="Project one" style="width: 100%;" /> </div>

                        <div class="padding_top_bottom_10"> <span class="font_14_gray"> Project Status </span> </div>
                        <select class="form-select form-control" style="width: 100%;" name="project_status" id="project_status">
                            @foreach ($projectStatus as $projectStat)
                                <option value="{{ $projectStat->id }}">{{ $projectStat->status_name  }}</option>
                            @endforeach
                        </select>

                        <div class="padding_top_bottom_10"> <span class="font_14_gray"> Project description</span> </div>
                        <textarea class="form-control" name="project_description" placeholder="Add description" style="width: 100%; height: 80px;"></textarea>
                    `;
            break;
        }
        step2Content.innerHTML = html;

        if (type === '2') {
            const devRadios = document.querySelectorAll('input[name="product_development_type"]');
            const existingSelect = document.getElementById('existingProjectSelect');
            const subProductSelect = document.getElementById('subProductSelect');
            const existingSubProductSelect = document.getElementById('existingSubProductSelect');

                devRadios.forEach(radio => {
                radio.addEventListener('change', function () {

                    existingSelect.style.display = 'none';
                    subProductSelect.style.display = 'none';
                    existingSubProductSelect.style.display = 'none';

                    if (this.value === 'exist_project') {

                        existingSelect.style.display = 'block';
                        
                    }

                    if (this.value === 'new_sub_product') {
                        subProductSelect.style.display = 'block';
                    }

                    if (this.value === 'exist_sub_product') {
                        existingSubProductSelect.style.display = 'block';
                    }

                });

            });

            $('.new-select').select2({
                dropdownParent: $('#projectModal'),
                width: '100%', 
            });

        }

    }

    // document.getElementById('projectForm').addEventListener('submit', function(e) {
    //   e.preventDefault();
    //   alert("Project Submitted!");
    //   modal.style.display = "none";
    //   currentStep = 1;
    //   showStep(currentStep);
    //   this.reset();
    // });
  </script>
