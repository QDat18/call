<div class="modal fade" id="settingsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="background: #1f2937; color: white;">
            <div class="modal-header border-bottom border-secondary">
                <h5 class="modal-title">
                    <i class="fas fa-cog me-2 text-primary"></i>Call Settings
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label text-white-50 small text-uppercase fw-bold">Microphone</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-white"><i class="fas fa-microphone"></i></span>
                        <select class="form-select bg-dark text-white border-secondary" id="audio-input-select">
                            <option value="">Default - Microphone (Built-in)</option>
                        </select>
                    </div>
                    <button class="btn btn-sm btn-outline-light mt-2 w-100" onclick="testAudio()">
                        <i class="fas fa-wave-square me-1"></i> Test Microphone
                    </button>
                </div>

                <div class="mb-3">
                    <label class="form-label text-white-50 small text-uppercase fw-bold">Speaker</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-white"><i class="fas fa-volume-up"></i></span>
                        <select class="form-select bg-dark text-white border-secondary" id="audio-output-select">
                            <option value="">Default - Speaker (Built-in)</option>
                        </select>
                    </div>
                    <button class="btn btn-sm btn-outline-light mt-2 w-100" onclick="testSpeaker()">
                        <i class="fas fa-play me-1"></i> Test Speaker
                    </button>
                </div>

                <div class="mb-3" style="{{ $callType === 'audio' ? 'display:none;' : '' }}">
                    <label class="form-label text-white-50 small text-uppercase fw-bold">Camera</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-white"><i class="fas fa-video"></i></span>
                        <select class="form-select bg-dark text-white border-secondary" id="video-input-select">
                            <option value="">Default - Camera (Built-in)</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3" style="{{ $callType === 'audio' ? 'display:none;' : '' }}">
                    <label class="form-label text-white-50 small text-uppercase fw-bold">Video Quality</label>
                    <select class="form-select bg-dark text-white border-secondary" id="video-quality-select">
                        <option value="360">Low (360p) - Save Data</option>
                        <option value="480">Medium (480p) - Balanced</option>
                        <option value="720" selected>HD (720p) - Good Quality</option>
                        <option value="1080">Full HD (1080p) - Best Quality</option>
                    </select>
                </div>

                <div class="form-check form-switch mb-3" style="{{ $callType === 'audio' ? 'display:none;' : '' }}">
                    <input class="form-check-input" type="checkbox" id="background-blur">
                    <label class="form-check-label" for="background-blur">Blur Background</label>
                </div>

                <div class="p-3 rounded bg-dark border border-secondary mt-3">
                    <label class="form-label text-white-50 small text-uppercase fw-bold mb-2">Connection Stats</label>
                    <div class="row g-2 text-center small font-monospace">
                        <div class="col-4">
                            <div class="text-white-50">Bitrate</div>
                            <div class="text-success" id="stat-bitrate">0 kbps</div>
                        </div>
                        <div class="col-4">
                            <div class="text-white-50">Packet Loss</div>
                            <div class="text-warning" id="stat-packet-loss">0%</div>
                        </div>
                        <div class="col-4">
                            <div class="text-white-50">Latency</div>
                            <div class="text-info" id="stat-latency">0 ms</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top border-secondary">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveSettings()">Save Changes</button>
            </div>
        </div>
    </div>
</div>