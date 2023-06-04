{
  description = "A Nix-flake-based everyworkflow development environment";

  inputs = {
    nixpkgs.url = "github:NixOS/nixpkgs/release-22.11";
    flake-utils.url = "github:numtide/flake-utils";
    nix-shell.url = "github:loophp/nix-shell";
  };

  outputs =
    { self, nixpkgs, flake-utils, nix-shell }:

    flake-utils.lib.eachDefaultSystem (system:
    let
      pkgs = import nixpkgs { inherit system; };

      php = (nix-shell.api.makePhp system {
        php = "php82";
        withExtensions = [
          "process"
          "pcntl"
          "posix"
          "ctype"
          "dom"
          "simplexml"
          "xmlwriter"
          "iconv"
          "mbstring"
          "intl"
          "filter"
          "curl"
          "openssl"
          "sodium"
          "tokenizer"
          "gd"
          "pdo"
          "redis"
          "mongodb"
        ];
        extraConfig = ''
          memory_limit = 256M
        '';
      });
    in
    {
      devShell = pkgs.mkShellNoCC {
          name = "EveryWorkflow product";

          buildInputs = [
            php
            php.packages.composer
            pkgs.symfony-cli
          ];
        };
    });
}
