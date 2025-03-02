# PHP MCP Demo

Simple demo gluing together [MCP](https://modelcontextprotocol.io/) with Symfony and [LLM Chain](https://github.com/php-llm/llm-chain) - heavily inspired by @lyrixx [MCP blog post](https://jolicode.com/blog/mcp-the-open-protocol-that-turns-llm-chatbots-into-intelligent-agents).

## Requirements

* PHP 8.4
* Composer
* Symfony CLI
* NPX

## Installation

Setting up the Symfony project:

```bash
git clone git@github.com:chr-hertel/mcp-demo.git
cd mcp-demo
composer install
symfony serve -d --no-tls
```

Running the MCP Inspector:

```bash
npx -y @modelcontextprotocol/inspector
```

## Usage

Open the MCP Inspector in your browser, for example at `http://localhost:5173/`.

For STDIO use:
* Transport Type: `STDIO`
* Command: `/path/to/mcp-demo/bin/console`
* Arguments: `mcp`

For SSE use:
* Transport Type: `SSE`
* URL: `http://localhost:8000/mcp/sse` (port might differ)

Click `Connect` and you should be able to use the tools of the Symfony app via the MCP Inspector.

![demo.png](demo.png)
