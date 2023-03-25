# Php challenge

In questo challenge ti viene richiesto di produrre uno script PHP che data una cartella contenente x sottocartelle con y files duplicati e triplicati (anche in sottocartelle diverse) generi un file CSV contenente unicamente i nomi files dei duplicati, la relativa ricorrenza ed i relativi paths (separati dal carattere ";") ; ad esempio, dato il seguente filesystem:
```
VIDEO
├── H-264
│   ├── 8mm_BW
│   │   ├── Tape_11.0.mp4
│   │   ├── Tape_57.0.mp4
│   │   ├── Tape_7.0.mp4
│   │   └── Tape_9.0.mp4
│   ├── Super8_BW
│   │   ├── Tape_01.0.mp4
│   │   ├── Tape_06.0.mp4
│   │   ├── Tape_22.0.mp4
│   │   ├── Tape_35.0.mp4
│   │   ├── Tape_38.0.mp4
│   │   ├── Tape_11.0.mp4
│   │   └── Tape_9.0.mp4
│   ├── Tape_11.0.mp4
```
il CSV generato sarà:
* Tape_9.0.mp4,2,\VIDEO\H-264\8mm_BW;\VIDEO\H-264\Super8_BW
* Tape_11.0.mp4,3,\VIDEO\H-264;\VIDEO\H-264\8mm_BW;\VIDEO\H-264\Super8_BW

## Come procedere

Forka questa repository e inizia a scrivere il tuo codice!
