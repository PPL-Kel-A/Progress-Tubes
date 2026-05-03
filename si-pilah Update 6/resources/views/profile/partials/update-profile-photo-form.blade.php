<section>
    <form method="post" action="{{ route('profile.uploadPhoto') }}" enctype="multipart/form-data" class="space-y-5" id="photoForm">
        @csrf

        <!-- Current Photo Display -->
        <div class="mb-6">
            <x-input-label for="current_photo" value="Foto Profil Saat Ini" />
            <div class="mt-3">
                @if ($user->profile_photo)
                    <div class="flex flex-col sm:flex-row gap-4 sm:gap-6">
                        <!-- Photo -->
                        <div class="flex-shrink-0">
                            <div class="relative inline-block">
                                <img src="{{ Storage::url($user->profile_photo) }}" 
                                     alt="Profile Photo" 
                                     class="w-20 h-20 rounded-xl object-cover shadow-md border-2 border-green-200">
                            </div>
                        </div>
                        
                        <!-- Info & Actions -->
                        <div class="flex-1 flex flex-col justify-center gap-3">
                            <div>
                                <p class="text-sm font-semibold text-gray-700">Foto Profil Aktif</p>
                                <p class="text-sm text-gray-600 mt-1 leading-relaxed">
                                    Klik tombol "<strong>Ubah Foto</strong>" di bawah untuk mengganti foto Anda dengan yang baru.
                                </p>
                            </div>
                            <form method="post" action="{{ route('profile.deletePhoto') }}" class="inline">
                                @csrf
                                @method('delete')
                                <button type="submit" 
                                        onclick="return confirm('Yakin ingin menghapus foto profil?')"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-semibold text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    Hapus Foto
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 items-start sm:items-center">
                        <div class="flex-shrink-0 w-20 h-20 rounded-xl flex items-center justify-center text-3xl font-extrabold text-green-800 shadow-md border-2 border-dashed border-green-300" style="background: linear-gradient(135deg, #a5d6a7, #c8e6c9);">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-700">Belum Ada Foto Profil</p>
                            <p class="text-sm text-gray-600 mt-1 leading-relaxed">
                                Unggah foto profil Anda sekarang untuk membuat akun Anda lebih personal dan mudah dikenali.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Photo Upload Input -->
        <div class="space-y-3">
            <x-input-label for="profile_photo" value="Ubah Foto Profil" />
            
            <div class="relative">
                <input type="file" 
                       id="profile_photo" 
                       name="profile_photo" 
                       accept="image/jpeg,image/png,image/gif,image/jpg"
                       onchange="previewPhoto(event)"
                       class="hidden">
                
                <!-- Upload Button -->
                <button type="button" 
                        id="selectPhotoBtn"
                        onclick="document.getElementById('profile_photo').click()"
                        class="w-full px-4 py-3 border-2 border-dashed border-green-300 rounded-lg hover:border-green-500 hover:bg-green-50 transition flex flex-col sm:flex-row items-center justify-center gap-2 text-gray-700 font-medium">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span class="text-center sm:text-left">📸 Pilih Foto (JPG, PNG, GIF • Max 2MB)</span>
                </button>
            </div>

            <!-- File Size Warning -->
            <div id="sizeWarning" class="hidden">
                <div class="bg-red-50 border border-red-200 rounded-lg px-4 py-3">
                    <p class="text-sm font-medium text-red-800 flex items-start gap-2">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <span id="warningText" class="leading-relaxed"></span>
                    </p>
                </div>
            </div>

            <!-- Preview Section -->
            <div id="photoPreview" class="hidden">
                <div class="bg-gradient-to-br from-green-50 to-blue-50 border border-green-200 rounded-lg p-4">
                    <p class="text-sm font-semibold text-gray-700 mb-3">📋 Preview Foto Baru:</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-shrink-0">
                            <img id="previewImage" 
                                 src="" 
                                 alt="Preview" 
                                 class="w-44 h-44 rounded-lg object-cover shadow-md border-2 border-green-300">
                        </div>
                        <div class="flex-1 grid grid-cols-2 sm:grid-cols-1 gap-3 text-sm">
                            <div class="bg-white p-3 rounded-lg border border-gray-200">
                                <p class="text-gray-600 text-xs font-medium mb-1">Nama File</p>
                                <p class="font-semibold text-gray-800 break-all" id="fileName"></p>
                            </div>
                            <div class="bg-white p-3 rounded-lg border border-gray-200">
                                <p class="text-gray-600 text-xs font-medium mb-1">Ukuran</p>
                                <p class="font-semibold text-gray-800" id="fileSize"></p>
                            </div>
                            <div class="bg-white p-3 rounded-lg border border-gray-200 col-span-2 sm:col-span-1">
                                <p class="text-gray-600 text-xs font-medium mb-1">Tipe File</p>
                                <p class="font-semibold text-gray-800 break-all" id="fileType"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
        </div>

        <!-- Info Text -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg px-4 py-3.5">
            <p class="flex items-start gap-3 text-sm text-blue-800">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                <span class="leading-relaxed"><strong>💡 Tips:</strong> Gunakan foto berkualitas tinggi dengan format JPG, PNG, atau GIF. Ukuran file tidak boleh lebih dari 2MB agar upload cepat.</span>
            </p>
        </div>

        <!-- Buttons Section -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2 border-t border-gray-200">
            <x-primary-button id="submitBtn" class="flex-1 sm:flex-none justify-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span id="submitText">Simpan Foto</span>
                <span id="loadingSpinner" class="hidden ml-2 inline-block">
                    <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
            </x-primary-button>

            <button type="button" 
                    onclick="clearPhotoPreview()"
                    id="clearBtn"
                    class="hidden px-4 py-2.5 text-gray-700 font-medium border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                ✕ Batalkan
            </button>

            <div class="flex-1 space-y-1">
                @if (session('status') === 'profile-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition.opacity.duration.500ms
                        x-init="setTimeout(() => show = false, 3000)"
                        class="text-sm font-medium text-green-700 bg-green-50 px-3 py-2 rounded-lg text-center sm:text-left"
                    >✅ Foto berhasil tersimpan!</p>
                @endif

                @if (session('status') === 'photo-deleted')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition.opacity.duration.500ms
                        x-init="setTimeout(() => show = false, 3000)"
                        class="text-sm font-medium text-amber-700 bg-amber-50 px-3 py-2 rounded-lg text-center sm:text-left"
                    >🗑️ Foto berhasil dihapus!</p>
                @endif
            </div>
        </div>
    </form>

    <script>
        const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }

        function previewPhoto(event) {
            const file = event.target.files[0];
            const sizeWarning = document.getElementById('sizeWarning');
            const warningText = document.getElementById('warningText');

            sizeWarning.classList.add('hidden');

            if (file) {
                // Validasi ukuran file
                if (file.size > MAX_FILE_SIZE) {
                    warningText.textContent = `Ukuran file terlalu besar! File Anda ${formatFileSize(file.size)}, maksimal 2MB. Silakan pilih file yang lebih kecil.`;
                    sizeWarning.classList.remove('hidden');
                    document.getElementById('selectPhotoBtn').classList.add('border-red-500', 'bg-red-50');
                    clearPhotoPreview();
                    return;
                }

                // Reset border jika file valid
                document.getElementById('selectPhotoBtn').classList.remove('border-red-500', 'bg-red-50');

                // Validasi tipe file
                const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
                if (!validTypes.includes(file.type)) {
                    warningText.textContent = `Format file tidak didukung! Gunakan JPG, PNG, atau GIF. File Anda: ${file.type}`;
                    sizeWarning.classList.remove('hidden');
                    clearPhotoPreview();
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImage').src = e.target.result;
                    document.getElementById('fileName').textContent = file.name;
                    document.getElementById('fileSize').textContent = formatFileSize(file.size);
                    document.getElementById('fileType').textContent = file.type;
                    document.getElementById('photoPreview').classList.remove('hidden');
                    document.getElementById('clearBtn').classList.remove('hidden');
                    document.getElementById('submitBtn').disabled = false;
                };
                reader.readAsDataURL(file);
            }
        }

        function clearPhotoPreview() {
            document.getElementById('profile_photo').value = '';
            document.getElementById('photoPreview').classList.add('hidden');
            document.getElementById('clearBtn').classList.add('hidden');
            document.getElementById('sizeWarning').classList.add('hidden');
            document.getElementById('selectPhotoBtn').classList.remove('border-red-500', 'bg-red-50');
        }

        // Handle form submission
        document.getElementById('photoForm').addEventListener('submit', function() {
            const file = document.getElementById('profile_photo').files[0];
            if (!file) {
                alert('Silakan pilih foto terlebih dahulu!');
                return false;
            }
            
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('submitText').classList.add('hidden');
            document.getElementById('loadingSpinner').classList.remove('hidden');
        });
    </script>
</section>
