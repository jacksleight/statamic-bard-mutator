---
title: Compatibility
order: 8
---

# Compatibility

In order to run tag mutators Bard Mutator has to replace the built-in classes/extensions with its own. It can only do that reliably if there are no other addons (or user code) trying to do the same thing. To help minimise incompatibilities Bard Mutator will only replace the classes/extensions that are actually being mutated, everyting else is left alone.

*However*, if you have other addons (or user code) that replace any of the classes/extensions that Bard Mutator is also replacing it probably won't work properly. Unfortunately I don’t think there’s a way around that. This does not affect custom nodes and marks.

My other Bard addons use Bard Mutator under the hood, so those are fully compatible. In fact the main reason I developed this in the first place was so multiple addons could make modifications to the built-in classes/extensions at the same time.
