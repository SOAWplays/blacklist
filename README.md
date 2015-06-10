Blacklist
=========

The data behind the Blacklist website, inspired by samczsun's "[Plugin Blacklist]" website.
This project is community driven, therefore some information may not be 100% correct but we will at least attempt to verify it before merging submissions.

Check out our [Chrome extension][cr-ext], it's still in the early stages but we're working on it!

Please review our contribution guidelines below before contributing. Failure to conform to our guidelines will result in your submissions being deleted.

## Collaborators
As requested by a member of the MCMarket community I have compiled a list of the GitHub users who I view as trusted. Each user on this list has read and write access to [this](https://github.com/Fireflies/blacklist) repository.
- [DarkSeraphim](https://github.com/DarkSeraphim)
- [samczsun](https://github.com/samczsun)
- [SpongyBacon](https://github.com/SpongyBacon)
- [vemacs](https://github.com/vemacs)
- [1Rogue](https://github.com/1Rogue)

## Contributing

### Plugins
1. Fork the repository.
2. Create a `yml` file named after the plugin and fill it using the format below.
3. Commit your files
4. Submit a pull request, bitches love pull requests!

##### Format
```yml
name: <plugin name>
status: Active
link: http://spigotmc.org/link/to/plugin
violations:
- Contains copyrighted code from <source>
```

### Users
1. Fork the repository.
2. Create a `yml` file named after the author and fill it using the format below.
  - If you are reporting a spigot username then please name the file exactly as their username appears in the URL
3. Commit your files
4. Submit a pull request, bitches love pull requests!

##### Format
```yml
id: <spigot forum ID>
username: <spigot username>
reasons:
- Why they're
- on the blacklist
```
You must provider at least their username and one reason.

**How can I find somebody's spigot ID?**
- Navigate to the spigot website and find the user's profile
- Copy the profile link (example: `www.spigotmc.org/members/charries96.17104/`)
- Copy the number at the end of the link (`17104`)

### Notes
- If an author goes by multiple aliases then use their most commonly known one, support for multiple names will be added later.
- Spaces in plugin names should be replaced with an underscore when creating the `yml` file.

[Plugin Blacklist]: http://samczsun.com/warning.html
[cr-ext]: https://chrome.google.com/webstore/detail/spigot-blacklist/aafgnkhgmjhodeebloogjbcijlgfnanp
