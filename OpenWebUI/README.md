# Open WebUI

Open WebUI is a self-hosted, feature-rich web interface for interacting with large language models (LLMs) and AI models. It provides a user-friendly chat interface with support for multiple model backends and advanced features like prompt engineering and model management.

## Configuration

- **Image**: Specified by `OPEN_WEBUI_IMAGE` in the root `.env` file.
- **Container Name**: `openwebui`.
- **Network**: Attached to the shared `docker_net` network via Caddy reverse proxy.
- **Restart Policy**: `unless-stopped` for automatic recovery.

### Environment Variables

Define these in the root `.env` file:

```env
OPEN_WEBUI_IMAGE=<image>
OPEN_WEBUI_SERVER_HOSTNAME=openwebui.example.com
SERVER_PROTOCOL=https
PRIVATE_API_KEY=<your-secret-key>
BASE_STORAGE_DIR=/blk
```

The `WEBUI_SECRET_KEY` is set to `PRIVATE_API_KEY` for session security.

### Persistent Storage

Data is stored on the host at `${BASE_STORAGE_DIR}/openwebui`, mapped to `/app/backend/data` in the container. This includes:

- User accounts and preferences
- Chat history and conversations
- Model configurations
- Uploaded files and attachments
- Application cache and database

## Usage

1. Include `OpenWebUI/docker-compose.yml` in your `COMPOSE_FILE`.
2. Start the service:
   ```sh
   docker compose up -d openwebui
   ```
3. Access Open WebUI at the configured hostname (e.g., `https://openwebui.example.com`).
4. Create an account and configure your LLM backend.
5. Start chatting with your AI models.

## Integration

Open WebUI can integrate with:
- Local LLM backends (Ollama, LM Studio)
- Remote LLM APIs (OpenAI, Anthropic, etc.)
- Custom model providers
- Hermes agents for autonomous task execution

## Features

- Multi-model support with easy switching
- Conversation management and history
- Prompt engineering and customization
- File uploads and document analysis
- User management and authentication
- Dark/light theme support
- Responsive web interface
