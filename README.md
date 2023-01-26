###Common
Every file consists from table with two columns
1) `key` - system key. should not be translated;
2) `translate` - string to translate it;

*NOTICE: Don't touch values under `key` column.*

### Rules
These rules applied to strings under `translate` column:
1. if string is empty, – **leave it empty too**.
2. words which BEGINS from `:` symbol, like `:max`, `:age` `:amount` (etc.) **are system keywords**. Leave this keywords in translated strigns **AS IS**. DO NOT REMOVE IT, just add translation for other parts.
3. sometimes strings contains system information like: `<b>:name</b>`.  For example: *Success! `<b>:name</b>` has been sent further instructions.* Leave this system info into the translated strings too.
   1. more examples (*keywords are highlighted*): `<b>1.25</b>`, `(:date)`, `:num Attendee(s)`, Check in: `:event`, View Order #`:num`, (`<b>:installed</b>`), New order received for `:event` [`:order`]